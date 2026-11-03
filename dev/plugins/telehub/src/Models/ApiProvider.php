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
            ->withOptions([
                'connect_timeout' => 8,
                'curl' => [
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                ],
            ])
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

            $response = $this->httpClient(10)
                ->retry(2, 500, function ($exception) {
                    return $exception instanceof \Illuminate\Http\Client\ConnectionException;
                }, throw: false)
                ->get($endpoint, $queryParams);

            if ($response->successful()) {
                $data = $response->json();
                $payload = $data['data'] ?? $data;

                if (isset($payload['balance'])) {
                    $this->balance = (float) $payload['balance'];
                } elseif (isset($payload['credit'])) {
                    $this->balance = (float) $payload['credit'];
                } elseif (isset($payload['balanceVnd'])) {
                    $this->balance = (float) $payload['balanceVnd'];
                } elseif (isset($data['balance'])) {
                    $this->balance = (float) $data['balance'];
                } elseif (isset($data['credit'])) {
                    $this->balance = (float) $data['credit'];
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
                } elseif (isset($payload['credit']) || isset($data['credit'])) {
                    $this->currency = 'USD';
                } else {
                    $this->currency = 'VND';
                }

                $requesterName = $payload['requester']['name'] ?? $data['requester']['name'] ?? $payload['full_name'] ?? $payload['username'] ?? $payload['dealer'] ?? $data['dealer'] ?? null;
                $requesterChatId = $payload['requester']['chatId'] ?? $data['requester']['chatId'] ?? $payload['user_id'] ?? $data['user_id'] ?? null;

                if (!empty($payload['partner_id']) && empty($this->partner_id)) {
                    $this->partner_id = $payload['partner_id'];
                } elseif (!empty($requesterChatId) && empty($this->partner_id)) {
                    $this->partner_id = 'tg_' . $requesterChatId;
                } elseif (!empty($payload['dealer']) && empty($this->partner_id)) {
                    $this->partner_id = 'dlr_' . \Illuminate\Support\Str::slug($payload['dealer']);
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

            $response = $this->httpClient(20)
                ->retry(2, 500, function ($exception) {
                    return $exception instanceof \Illuminate\Http\Client\ConnectionException;
                }, throw: false)
                ->get($endpoint, $queryParams);

            if ($response->successful()) {
                $data = $response->json();

                // Cập nhật số dư nếu có trong response catalog (như Lay2FA /api/dealer/stock hoặc Safe24 /api/profile)
                if (isset($data['balance'])) {
                    $this->balance = (float) $data['balance'];
                    $this->last_sync_at = now();
                    $this->save();
                } elseif (isset($data['credit'])) {
                    $this->balance = (float) $data['credit'];
                    $this->last_sync_at = now();
                    $this->save();
                }

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

                // Hỗ trợ API dạng đơn lẻ chuyên biệt (như Safe24 / Offer Pixel Bot chạy job qua /api/profile)
                if (empty($rawList) && (isset($data['price']) || isset($data['credit']) || str_contains($this->base_url, 'apisafe24'))) {
                    $unitPriceUsd = (float)($data['price'] ?? 1.2);
                    $unitPriceVnd = (float)round($unitPriceUsd * 26000, -3);

                    $rawList[] = [
                        'product_id' => 'offer_pixel_google_one',
                        'name' => 'Kích Hoạt Gói Google One 2TB (Pixel Offer)',
                        'price' => $unitPriceVnd,
                        'cost_price' => $unitPriceVnd,
                        'price_usd' => $unitPriceUsd,
                        'stock_count' => 999,
                        'available' => true,
                        'delivery_mode' => 'account_upgrade',
                        'category' => 'Upgrade',
                        'description' => "Dịch vụ kích hoạt gói Google One 2TB chính chủ chất lượng cao.\n📦 Định dạng gửi thông tin: Email | Mật khẩu | Mã 2FA TOTP (nếu có)\n⚡ Xử lý tự động nhanh chóng và bảo hành gói dịch vụ.",
                    ];
                }

                $products = [];
                foreach ($rawList as $p) {
                    if (!is_array($p)) continue;
                    // Support product_id, productId, product_key, id, and name fallback
                    $pId = (string)($p['product_id'] ?? $p['productId'] ?? $p['product_key'] ?? $p['id'] ?? $p['name'] ?? '');
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
                    if ($stock < 0) {
                        $stock = 0; // Tránh âm khi API trả về -1 (đang cập nhật)
                    }

                    $sold = 0;
                    if (isset($p['availability']) && is_array($p['availability'])) {
                        $sold = (int)($p['availability']['sold'] ?? 0);
                    } else {
                        $sold = (int)($p['sold_count'] ?? $p['sold'] ?? $p['sales'] ?? 0);
                    }

                    $available = isset($p['available']) ? (bool)$p['available'] : ($stock > 0);
                    if ($availableOnly && (!$available || $stock <= 0)) {
                        continue;
                    }

                    $deliveryMode = $p['delivery_mode'] ?? ($p['productType'] ?? ($p['type'] ?? 'instant_items'));

                    $products[] = [
                        'product_id' => $pId,
                        'name' => $p['name'] ?? $p['title'] ?? ('Sản phẩm ' . $pId),
                        'price' => $price,
                        'stock_count' => $stock,
                        'sold_count' => $sold,
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
            'product_key' => $apiProductId, // Supports Lay2FA CTV API which requires product_key
            'quantity' => $quantity,
            'qty' => $quantity, // Supports Lay2FA CTV API which requires qty
            'partner_ref' => $partnerRef,
            'request_id' => $partnerRef,
            'order_code' => $partnerRef, // Supports Lay2FA CTV API order_code
            'key' => trim($this->api_key), // Supports Canboso & standard APIs
        ];

        if (!empty($emails)) {
            $body['emails'] = $emails;
            $body['customer_email'] = $emails[0] ?? null;
        }

        // Hỗ trợ API dạng Create Job chạy tài khoản (Safe24 / Google One / Offer Pixel)
        if (str_contains($endpoint, 'jobs/create') || str_contains($this->base_url, 'apisafe24')) {
            $credStr = $emails[0] ?? '';
            $parts = explode('|', $credStr);
            $body['email'] = trim($parts[0] ?? ($body['customer_email'] ?? ''));
            $body['password'] = trim($parts[1] ?? '');
            $body['totp_secret'] = trim($parts[2] ?? '');
        }

        try {
            $headers = [
                'Idempotency-Key' => $partnerRef,
                'x-idempotency-key' => $partnerRef,
                'Content-Type' => 'application/json',
            ];

            $response = $this->httpClient(35)
                ->withHeaders($headers)
                ->retry(2, 1000, function ($exception) {
                    return $exception instanceof \Illuminate\Http\Client\ConnectionException;
                }, throw: false)
                ->post($endpoint, $body);

            $json = $response->json();

            if ($response->successful()) {
                if (isset($json['success']) && $json['success'] === false) {
                    $errorMessage = $json['error'] ?? $json['detail'] ?? $json['message'] ?? 'API error';
                    return [
                        'success' => false,
                        'status_code' => $response->status(),
                        'error' => $errorMessage,
                        'raw' => $json,
                    ];
                }
                if (isset($json['ok']) && $json['ok'] === false) {
                    $errorMessage = $json['error'] ?? $json['detail'] ?? $json['message'] ?? 'API error';
                    return [
                        'success' => false,
                        'status_code' => $response->status(),
                        'error' => $errorMessage,
                        'raw' => $json,
                    ];
                }

                $respData = $json['data'] ?? $json['order'] ?? $json;
                $orderCode = $respData['job_id'] ?? $json['job_id'] ?? $respData['order_code'] ?? $respData['orderCode'] ?? $json['order']['orderCode'] ?? $respData['order_id'] ?? $respData['id'] ?? $partnerRef;

                // Delivery accounts from Canboso vs standard vs Lay2FA vs Safe24
                $items = [];
                if (!empty($respData['job_id']) || !empty($json['job_id'])) {
                    $jobId = $respData['job_id'] ?? $json['job_id'];
                    $items = ["Tiến trình Safe24 (Job ID): {$jobId} | Xem trạng thái tại /api/jobs/status/{$jobId}"];
                } elseif (!empty($json['delivery']['accounts'])) {
                    $items = $json['delivery']['accounts'];
                } elseif (!empty($respData['delivery']['accounts'])) {
                    $items = $respData['delivery']['accounts'];
                } elseif (!empty($respData['cards'])) {
                    $items = $respData['cards'];
                } else {
                    $items = $respData['items'] ?? $respData['accounts'] ?? [];
                }

                $status = $respData['status'] ?? $json['order']['status'] ?? 'done';
                $balanceAfter = $json['credit'] ?? $respData['credit'] ?? $json['balance_remaining'] ?? $respData['balance_remaining'] ?? $json['payment']['balance'] ?? $respData['payment']['balance'] ?? $respData['balance'] ?? $respData['balance_after'] ?? $respData['new_balance'] ?? null;

                if ($balanceAfter !== null) {
                    $this->balance = (float) $balanceAfter;
                    $this->last_sync_at = now();
                    $this->save();
                }

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

            $errorMessage = $json['error'] ?? $json['detail'] ?? $json['message'] ?? 'API error';
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
