<?php

namespace Dev\Telehub\Models;

use Dev\Base\Models\BaseModel;
use Dev\Telehub\Traits\HasTenant;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiProvider extends BaseModel
{
    use HasTenant;

    protected $table = 'telehub_api_providers';

    protected $fillable = [
        'tenant_id',
        'name',
        'base_url',
        'auth_type',
        'header_name',
        'api_key',
        'partner_id',
        'endpoint_catalog',
        'endpoint_orders',
        'endpoint_balance',
        'balance',
        'currency',
        'status',
        'last_sync_at',
        'raw_data',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'last_sync_at' => 'datetime',
        'raw_data' => 'array',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'api_provider_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'api_provider_id');
    }

    /**
     * Build HTTP client with base url, headers and authentication.
     */
    public function httpClient(int $timeout = 15): \Illuminate\Http\Client\PendingRequest
    {
        $headers = [
            'Accept' => 'application/json',
            'User-Agent' => 'Telehub-Bot/2.0',
        ];

        $apiKey = trim($this->api_key);
        $headerKey = $this->header_name ?: 'X-API-Key';

        if ($this->auth_type === 'bearer') {
            $headers['Authorization'] = 'Bearer ' . $apiKey;
        } else {
            $headers[$headerKey] = $apiKey;
        }

        $baseUrl = rtrim($this->base_url, '/');

        return Http::baseUrl($baseUrl)
            ->withHeaders($headers)
            ->timeout($timeout);
    }

    /**
     * Call balance endpoint to check live balance and partner profile.
     */
    public function checkBalance(): array
    {
        $endpoint = '/' . ltrim($this->endpoint_balance ?: '/api/v2/me', '/');

        try {
            $queryParams = [
                'key' => trim($this->api_key),
            ];

            $response = $this->httpClient(10)->get($endpoint, $queryParams);

            if ($response->successful()) {
                $data = $response->json();
                $payload = $data['data'] ?? $data;

                if (isset($payload['balance'])) {
                    $this->balance = (float) $payload['balance'];
                } elseif (isset($payload['balanceVnd'])) {
                    $this->balance = (float) $payload['balanceVnd'];
                } elseif (isset($data['balance'])) {
                    $this->balance = (float) $data['balance'];
                } elseif (isset($data['balanceVnd'])) {
                    $this->balance = (float) $data['balanceVnd'];
                }

                if (!empty($payload['currency'])) {
                    $this->currency = $payload['currency'];
                } elseif (!empty($payload['walletCurrency'])) {
                    $this->currency = $payload['walletCurrency'];
                } elseif (!empty($data['currency'])) {
                    $this->currency = $data['currency'];
                } elseif (!empty($data['walletCurrency'])) {
                    $this->currency = $data['walletCurrency'];
                } else {
                    $this->currency = 'VND';
                }

                $requesterName = $payload['requester']['name'] ?? $data['requester']['name'] ?? null;
                $requesterChatId = $payload['requester']['chatId'] ?? $data['requester']['chatId'] ?? null;

                if (!empty($payload['partner_id']) && empty($this->partner_id)) {
                    $this->partner_id = $payload['partner_id'];
                } elseif (!empty($requesterChatId) && empty($this->partner_id)) {
                    $this->partner_id = 'tg_' . $requesterChatId;
                }

                $this->last_sync_at = now();
                $this->raw_data = $payload;
                $this->save();

                return [
                    'success' => true,
                    'balance' => $this->balance,
                    'currency' => $this->currency,
                    'partner_id' => $payload['partner_id'] ?? $this->partner_id,
                    'name' => $requesterName ?? ($payload['name'] ?? $this->name),
                    'total_orders' => $payload['total_orders'] ?? 0,
                    'raw' => $payload,
                ];
            }

            return [
                'success' => false,
                'status_code' => $response->status(),
                'error' => $response->json('message') ?? $response->json('detail') ?? $response->json('error') ?? $response->body(),
            ];
        } catch (\Throwable $e) {
            Log::error("ApiProvider checkBalance error [{$this->id}]: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Fetch catalog of products from provider.
     */
    public function fetchCatalog(bool $availableOnly = false): array
    {
        $endpoint = '/' . ltrim($this->endpoint_catalog ?: '/api/v2/catalog', '/');

        try {
            $queryParams = [
                'available_only' => $availableOnly ? 'true' : 'false',
                'limit' => 500,
                'key' => trim($this->api_key),
            ];

            $response = $this->httpClient(20)->get($endpoint, $queryParams);

            if ($response->successful()) {
                $data = $response->json();
                $rawList = [];
                if (is_array($data) && array_is_list($data)) {
                    $rawList = $data;
                } elseif (isset($data['data']['products']) && is_array($data['data']['products'])) {
                    if (!array_is_list($data['data']['products'])) {
                        foreach ($data['data']['products'] as $pName => $pInfo) {
                            if (is_array($pInfo)) {
                                $rawList[] = array_merge([
                                    'product_id' => (string) $pName,
                                    'name' => (string) $pName,
                                ], $pInfo);
                            }
                        }
                    } else {
                        $rawList = $data['data']['products'];
                    }
                } elseif (isset($data['products']) && is_array($data['products'])) {
                    if (!array_is_list($data['products'])) {
                        foreach ($data['products'] as $pName => $pInfo) {
                            if (is_array($pInfo)) {
                                $rawList[] = array_merge([
                                    'product_id' => (string) $pName,
                                    'name' => (string) $pName,
                                ], $pInfo);
                            }
                        }
                    } else {
                        $rawList = $data['products'];
                    }
                } elseif (isset($data['data']) && is_array($data['data']) && array_is_list($data['data'])) {
                    $rawList = $data['data'];
                }

                $products = [];
                foreach ($rawList as $p) {
                    if (!is_array($p)) continue;
                    // Support product_id, productId, id, and name fallback
                    $pId = (string)($p['product_id'] ?? $p['productId'] ?? $p['id'] ?? $p['name'] ?? '');
                    if (!$pId) continue;

                    // Support price as number or as object { amount: 12345, currency: 'VND' }
                    $price = 0;
                    if (isset($p['price'])) {
                        if (is_array($p['price'])) {
                            $price = (float)($p['price']['amount'] ?? $p['price']['value'] ?? 0);
                        } else {
                            $price = (float)$p['price'];
                        }
                    } else {
                        $price = (float)($p['cost_price'] ?? 0);
                    }

                    // Support availability as object { available: 67, sold: ... } or stock_count / stock / quantity
                    $stock = 0;
                    if (isset($p['availability']) && is_array($p['availability'])) {
                        $stock = (int)($p['availability']['available'] ?? 0);
                    } else {
                        $stock = (int)($p['stock_count'] ?? $p['stock'] ?? $p['quantity'] ?? 0);
                    }

                    $available = isset($p['available']) ? (bool)$p['available'] : ($stock > 0);
                    if ($availableOnly && (!$available || $stock <= 0)) {
                        continue;
                    }

                    $deliveryMode = $p['delivery_mode'] ?? ($p['productType'] ?? 'instant_items');

                    $products[] = [
                        'product_id' => $pId,
                        'name' => $p['name'] ?? $p['title'] ?? ('Sản phẩm ' . $pId),
                        'price' => $price,
                        'stock_count' => $stock,
                        'available' => $available,
                        'delivery_mode' => $deliveryMode,
                        'category' => $p['category'] ?? null,
                        'description' => $p['description'] ?? null,
                        'image' => $p['image'] ?? null,
                        'emoji' => $p['emoji'] ?? null,
                    ];
                }

                $total = count($products);

                return [
                    'success' => true,
                    'products' => $products,
                    'total' => $total,
                ];
            }

            return [
                'success' => false,
                'status_code' => $response->status(),
                'error' => $response->json('message') ?? $response->json('detail') ?? $response->json('error') ?? $response->body(),
            ];
        } catch (\Throwable $e) {
            Log::error("ApiProvider fetchCatalog error [{$this->id}]: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Create order directly with upstream API provider.
     */
    public function placeOrder(string $apiProductId, int $quantity, string $partnerRef, array $emails = []): array
    {
        $endpoint = '/' . ltrim($this->endpoint_orders ?: '/api/v2/orders', '/');

        $body = [
            'product_id' => $apiProductId,
            'product_name' => $apiProductId, // Supports MinhAIS which requires product_name
            'quantity' => $quantity,
            'partner_ref' => $partnerRef,
            'request_id' => $partnerRef,
            'key' => trim($this->api_key), // Supports Canboso & standard APIs
        ];

        if (!empty($emails)) {
            $body['emails'] = $emails;
            $body['customer_email'] = $emails[0] ?? null;
        }

        try {
            $headers = [
                'Idempotency-Key' => $partnerRef,
                'x-idempotency-key' => $partnerRef,
                'Content-Type' => 'application/json',
            ];

            $response = $this->httpClient(35)
                ->withHeaders($headers)
                ->post($endpoint, $body);

            $json = $response->json();

            if ($response->successful()) {
                if (isset($json['success']) && $json['success'] === false) {
                    $errorMessage = $json['detail'] ?? $json['message'] ?? $json['error'] ?? 'API error';
                    return [
                        'success' => false,
                        'status_code' => $response->status(),
                        'error' => $errorMessage,
                        'raw' => $json,
                    ];
                }
                if (isset($json['ok']) && $json['ok'] === false) {
                    $errorMessage = $json['detail'] ?? $json['message'] ?? $json['error'] ?? 'API error';
                    return [
                        'success' => false,
                        'status_code' => $response->status(),
                        'error' => $errorMessage,
                        'raw' => $json,
                    ];
                }

                $respData = $json['data'] ?? $json['order'] ?? $json;
                $orderCode = $respData['order_code'] ?? $respData['orderCode'] ?? $json['order']['orderCode'] ?? $respData['order_id'] ?? $respData['id'] ?? $partnerRef;

                // Delivery accounts from Canboso vs standard
                $items = [];
                if (!empty($json['delivery']['accounts'])) {
                    $items = $json['delivery']['accounts'];
                } elseif (!empty($respData['delivery']['accounts'])) {
                    $items = $respData['delivery']['accounts'];
                } elseif (!empty($respData['cards'])) {
                    $items = $respData['cards'];
                } else {
                    $items = $respData['items'] ?? $respData['accounts'] ?? [];
                }

                $status = $respData['status'] ?? $json['order']['status'] ?? 'done';
                $balanceAfter = $json['payment']['balance'] ?? $respData['payment']['balance'] ?? $respData['balance'] ?? $respData['balance_after'] ?? $respData['new_balance'] ?? null;

                return [
                    'success' => true,
                    'data' => $respData,
                    'order_code' => $orderCode,
                    'items' => $items,
                    'balance_after' => $balanceAfter,
                    'status' => $status,
                    'raw' => $json,
                ];
            }

            $errorMessage = $json['detail'] ?? $json['message'] ?? $json['error'] ?? 'API error';
            return [
                'success' => false,
                'status_code' => $response->status(),
                'error' => $errorMessage,
                'raw' => $json,
            ];
        } catch (\Throwable $e) {
            Log::error("ApiProvider placeOrder error [{$this->id}]: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
