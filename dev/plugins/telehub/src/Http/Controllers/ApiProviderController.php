<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Telehub\Models\ApiProvider;
use Dev\Telehub\Models\Order;
use Dev\Telehub\Models\Product;
use Dev\Telehub\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiProviderController extends BaseController
{
    public function index(Request $request)
    {
        $this->pageTitle('Kết Nối API (Đấu Nối Nhà Cung Cấp)');

        $user = Auth::user();
        $isAdmin = $user ? $user->isSuperUser() : false;
        $tenantId = null;

        if (!$isAdmin) {
            $tenant = Tenant::current();
            $tenantId = $tenant ? $tenant->id : null;
        }

        $query = ApiProvider::query();
        if (!$isAdmin && $tenantId) {
            $query->where('tenant_id', $tenantId);
        } elseif ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->input('tenant_id'));
        }

        $providers = $query->withCount(['products', 'orders'])
            ->orderBy('id', 'desc')
            ->get();

        $firstProvider = $providers->first();
        $initialCatalog = null;
        if ($firstProvider) {
            try {
                $catRes = $firstProvider->fetchCatalog(false);
                if (!empty($catRes['success']) && !empty($catRes['products'])) {
                    $importedMap = Product::where('api_provider_id', $firstProvider->id)
                        ->get()
                        ->keyBy('api_product_id');

                    $initialCatalog = [
                        'provider_id' => $firstProvider->id,
                        'provider_name' => $firstProvider->name,
                        'products' => array_map(function ($p) use ($importedMap, $firstProvider) {
                            $apiProdId = (string) ($p['product_id'] ?? '');
                            $imported = $importedMap->has($apiProdId);
                            $shopProd = $imported ? $importedMap->get($apiProdId) : null;

                            return array_merge($p, [
                                'provider_id' => $firstProvider->id,
                                'provider_name' => $firstProvider->name,
                                'imported' => $imported,
                                'shop_product_id' => $shopProd ? $shopProd->id : null,
                                'shop_price' => $shopProd ? (float) $shopProd->price : null,
                                'shop_status' => $shopProd ? (string) $shopProd->status : null,
                                'shop_markup' => $shopProd ? (float) $shopProd->api_markup_percent : null,
                                'shop_icon' => $shopProd ? (string) $shopProd->icon : null,
                            ]);
                        }, $catRes['products']),
                    ];
                }
            } catch (\Throwable $e) {
                // Ignore API timeout
            }
        }

        // Tính toán thống kê đơn hàng API & Tổng lợi nhuận Full
        $apiOrdersQuery = Order::whereNotNull('api_provider_id');
        if (!$isAdmin && $tenantId) {
            $apiOrdersQuery->where('tenant_id', $tenantId);
        }
        $allApiOrders = $apiOrdersQuery->with(['details.product'])->get();

        $totalApiOrders = $allApiOrders->count();
        $totalApiRevenue = 0;
        $totalApiCost = 0;

        foreach ($allApiOrders as $ord) {
            $rev = (float) $ord->total_amount;
            $cost = 0;
            if (!empty($ord->api_response)) {
                $respData = is_string($ord->api_response) ? json_decode($ord->api_response, true) : $ord->api_response;
                if (!empty($respData['data']['total_price'])) {
                    $cost = (float) $respData['data']['total_price'];
                } elseif (!empty($respData['total_price'])) {
                    $cost = (float) $respData['total_price'];
                }
            }
            if ($cost <= 0) {
                foreach ($ord->details as $d) {
                    $cost += ((float) ($d->product->api_cost_price ?? 0)) * ((int) ($d->quantity ?? 1));
                }
            }
            $totalApiRevenue += $rev;
            $totalApiCost += $cost;
        }

        $totalApiProfit = $totalApiRevenue - $totalApiCost;
        $profitMarginPct = $totalApiCost > 0 ? round(($totalApiProfit / $totalApiCost) * 100, 1) : 0;

        $apiStats = [
            'total_orders' => $totalApiOrders,
            'total_revenue' => $totalApiRevenue,
            'total_cost' => $totalApiCost,
            'total_profit' => $totalApiProfit,
            'profit_margin_pct' => $profitMarginPct,
        ];

        return view('plugins/telehub::api-providers', compact('isAdmin', 'tenantId', 'providers', 'initialCatalog', 'apiStats'));
    }

    public function list(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->isSuperUser();

        $query = ApiProvider::query();

        if (!$isAdmin) {
            $tenant = Tenant::current();
            $query->where('tenant_id', $tenant ? $tenant->id : -1);
        } elseif ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->input('tenant_id'));
        }

        $providers = $query->withCount(['products', 'orders'])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $providers,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'base_url' => 'required|url|max:255',
            'api_key' => 'required|string',
            'auth_type' => 'nullable|string|in:header,bearer',
            'header_name' => 'nullable|string|max:100',
            'partner_id' => 'nullable|string|max:100',
        ]);

        $user = Auth::user();
        $isAdmin = $user->isSuperUser();
        $tenantId = null;

        if (!$isAdmin) {
            $tenant = Tenant::current();
            $tenantId = $tenant ? $tenant->id : null;
        } elseif ($request->filled('tenant_id')) {
            $tenantId = (int) $request->input('tenant_id');
        } else {
            $firstTenant = Tenant::first();
            $tenantId = $firstTenant ? $firstTenant->id : null;
        }

        $provider = new ApiProvider();
        $provider->tenant_id = $tenantId;
        $provider->name = trim($request->input('name'));
        $provider->base_url = rtrim(trim($request->input('base_url')), '/');
        $provider->auth_type = $request->input('auth_type', 'header');
        $provider->header_name = trim($request->input('header_name', 'X-API-Key')) ?: 'X-API-Key';
        $provider->api_key = trim($request->input('api_key'));
        $provider->partner_id = trim((string) $request->input('partner_id', '')) ?: null;
        $provider->endpoint_catalog = trim((string) $request->input('endpoint_catalog', '/api/v2/catalog')) ?: '/api/v2/catalog';
        $provider->endpoint_orders = trim((string) $request->input('endpoint_orders', '/api/v2/orders')) ?: '/api/v2/orders';
        $provider->endpoint_balance = trim((string) $request->input('endpoint_balance', '/api/v2/me')) ?: '/api/v2/me';
        $provider->status = $request->input('status', 'active');
        $provider->save();

        // Check connection and live balance immediately
        $ping = $provider->checkBalance();

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm kết nối API thành công!',
            'data' => $provider->fresh(),
            'ping' => $ping,
        ]);
    }

    public function update(Request $request, $id)
    {
        $provider = ApiProvider::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:191',
            'base_url' => 'required|url|max:255',
            'api_key' => 'required|string',
            'auth_type' => 'nullable|string|in:header,bearer',
            'header_name' => 'nullable|string|max:100',
            'partner_id' => 'nullable|string|max:100',
        ]);

        $provider->name = trim($request->input('name'));
        $provider->base_url = rtrim(trim($request->input('base_url')), '/');
        $provider->auth_type = $request->input('auth_type', 'header');
        $provider->header_name = trim($request->input('header_name', 'X-API-Key')) ?: 'X-API-Key';
        $provider->api_key = trim($request->input('api_key'));
        $provider->partner_id = trim((string) $request->input('partner_id', '')) ?: null;
        $provider->endpoint_catalog = trim((string) $request->input('endpoint_catalog', '/api/v2/catalog')) ?: '/api/v2/catalog';
        $provider->endpoint_orders = trim((string) $request->input('endpoint_orders', '/api/v2/orders')) ?: '/api/v2/orders';
        $provider->endpoint_balance = trim((string) $request->input('endpoint_balance', '/api/v2/me')) ?: '/api/v2/me';
        $provider->status = $request->input('status', 'active');
        $provider->save();

        $ping = $provider->checkBalance();

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật kết nối API thành công!',
            'data' => $provider->fresh(),
            'ping' => $ping,
        ]);
    }

    public function destroy($id)
    {
        $provider = ApiProvider::findOrFail($id);

        $hasProducts = Product::where('api_provider_id', $provider->id)->exists();
        if ($hasProducts) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa vì còn sản phẩm trong kho đang liên kết với API này. Hãy hủy liên kết hoặc xóa các sản phẩm đó trước!',
            ], 422);
        }

        $provider->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa kết nối API thành công!',
        ]);
    }

    public function checkBalance($id)
    {
        $provider = ApiProvider::findOrFail($id);
        $res = $provider->checkBalance();

        return response()->json($res);
    }

    public function catalog($id, Request $request)
    {
        $provider = ApiProvider::findOrFail($id);
        $availableOnly = filter_var($request->input('available_only', false), FILTER_VALIDATE_BOOLEAN);

        $res = $provider->fetchCatalog($availableOnly);

        if (!$res['success']) {
            return response()->json($res, 400);
        }

        // Get currently imported products for this provider and tenant
        $importedMap = Product::where('api_provider_id', $provider->id)
            ->get()
            ->keyBy('api_product_id');

        $products = array_map(function ($p) use ($importedMap, $provider) {
            $apiProdId = (string) ($p['product_id'] ?? '');
            $imported = $importedMap->has($apiProdId);
            $shopProd = $imported ? $importedMap->get($apiProdId) : null;

            return array_merge($p, [
                'provider_id' => $provider->id,
                'provider_name' => $provider->name,
                'imported' => $imported,
                'shop_product_id' => $shopProd ? $shopProd->id : null,
                'shop_price' => $shopProd ? (float) $shopProd->price : null,
                'shop_status' => $shopProd ? (string) $shopProd->status : null,
                'shop_markup' => $shopProd ? (float) $shopProd->api_markup_percent : null,
                'shop_icon' => $shopProd ? (string) $shopProd->icon : null,
            ]);
        }, $res['products']);

        return response()->json([
            'success' => true,
            'provider' => [
                'id' => $provider->id,
                'name' => $provider->name,
                'base_url' => $provider->base_url,
                'balance' => $provider->balance,
                'currency' => $provider->currency,
            ],
            'products' => $products,
            'total' => count($products),
        ]);
    }

    public function import(Request $request, $id)
    {
        $provider = ApiProvider::findOrFail($id);

        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|string',
            'items.*.name' => 'required|string',
            'items.*.cost_price' => 'required|numeric|min:0',
            'items.*.sale_price' => 'required|numeric|min:0',
        ]);

        $items = $request->input('items');
        $tenantId = $provider->tenant_id;

        $importedCount = 0;
        $updatedCount = 0;

        foreach ($items as $item) {
            $apiProdId = trim($item['product_id']);
            $costPrice = (float) $item['cost_price'];
            $salePrice = (float) $item['sale_price'];
            $stock = (int) ($item['stock_count'] ?? 0);
            $deliveryMode = $item['delivery_mode'] ?? 'instant_items';
            $markup = isset($item['markup_percent']) ? (float) $item['markup_percent'] : null;
            $icon = isset($item['icon']) ? trim((string) $item['icon']) : null;

            $product = Product::where('tenant_id', $tenantId)
                ->where('api_provider_id', $provider->id)
                ->where('api_product_id', $apiProdId)
                ->first();

            $targetStatus = (isset($item['status']) && in_array($item['status'], ['published', 'draft'])) ? $item['status'] : null;

            if ($product) {
                $product->name = $item['name'];
                $product->price = $salePrice;
                $product->api_cost_price = $costPrice;
                $product->api_stock = $stock;
                $product->api_delivery_mode = $deliveryMode;
                $product->api_markup_percent = $markup;
                if ($icon !== null && $icon !== '') {
                    $product->icon = $icon;
                }
                if (!empty($item['description'])) $product->description = $item['description'];
                if ($targetStatus) {
                    $product->status = $targetStatus;
                } else {
                    $product->status = 'published';
                }
                $product->is_api_product = true;
                $product->save();
                $updatedCount++;
            } else {
                $product = new Product();
                $product->tenant_id = $tenantId;
                $product->name = $item['name'];
                $product->name_en = $item['name_en'] ?? null;
                $product->icon = ($icon !== null && $icon !== '') ? $icon : '5312361253610475399';
                $product->price = $salePrice;
                $product->price_usd = null;
                $product->description = $item['description'] ?? null;
                $product->status = $targetStatus ?: 'published';
                $product->is_api_product = true;
                $product->api_provider_id = $provider->id;
                $product->api_product_id = $apiProdId;
                $product->api_cost_price = $costPrice;
                $product->api_stock = $stock;
                $product->api_delivery_mode = $deliveryMode;
                $product->api_markup_percent = $markup;
                $product->save();
                $importedCount++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Đã import thành công: {$importedCount} sản phẩm mới, cập nhật {$updatedCount} sản phẩm đã có!",
            'imported' => $importedCount,
            'updated' => $updatedCount,
        ]);
    }

    public function toggleProductStatus(Request $request, $id)
    {
        $provider = ApiProvider::findOrFail($id);
        $tenantId = $provider->tenant_id;
        $apiProdId = trim((string) $request->input('product_id'));
        $targetStatus = $request->input('status');

        $product = Product::where('tenant_id', $tenantId)
            ->where('api_provider_id', $provider->id)
            ->where('api_product_id', $apiProdId)
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm này chưa được lưu vào shop!',
            ], 404);
        }

        if ($targetStatus && in_array($targetStatus, ['published', 'draft'])) {
            $product->status = $targetStatus;
        } else {
            $product->status = ($product->status == 'published') ? 'draft' : 'published';
        }

        $product->save();

        $isPublished = ($product->status == 'published');
        $statusLabel = $isPublished ? 'BẬT BÁN (Hiển thị Bot)' : 'TẠM ẨN (Ngừng bán Bot)';

        return response()->json([
            'success' => true,
            'message' => "Đã chuyển sản phẩm \"{$product->name}\" sang {$statusLabel}!",
            'status' => (string) $product->status,
            'product_id' => $apiProdId,
        ]);
    }

    public function unlinkProduct(Request $request, $id)
    {
        $provider = ApiProvider::findOrFail($id);
        $tenantId = $provider->tenant_id;

        $productIds = $request->input('product_ids');
        if (!$productIds && $request->filled('product_id')) {
            $productIds = [$request->input('product_id')];
        }

        if (empty($productIds) || !is_array($productIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng chọn ít nhất 1 sản phẩm để gỡ khỏi shop!',
            ], 422);
        }

        $products = Product::where('tenant_id', $tenantId)
            ->where('api_provider_id', $provider->id)
            ->whereIn('api_product_id', $productIds)
            ->get();

        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm nào phù hợp để gỡ!',
            ], 404);
        }

        $removedCount = 0;
        foreach ($products as $prod) {
            $hasOrderDetails = \Dev\Telehub\Models\OrderDetail::where('product_id', $prod->id)->exists();

            if ($hasOrderDetails) {
                // Đã có đơn hàng: Hủy liên kết API và set draft để bảo toàn lịch sử đơn
                $prod->api_provider_id = null;
                $prod->api_product_id = null;
                $prod->is_api_product = false;
                $prod->status = 'draft';
                $prod->save();
            } else {
                // Chưa có đơn hàng: Xóa hẳn record sản phẩm
                $prod->delete();
            }
            $removedCount++;
        }

        return response()->json([
            'success' => true,
            'message' => "Đã loại bỏ {$removedCount} sản phẩm ra khỏi shop thành công!",
            'removed_count' => $removedCount,
            'removed_ids' => $productIds,
        ]);
    }

    public function bulkStatus(Request $request, $id)
    {
        $provider = ApiProvider::findOrFail($id);
        $tenantId = $provider->tenant_id;
        $productIds = $request->input('product_ids', []);
        $status = $request->input('status', 'published');

        if (empty($productIds) || !is_array($productIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng chọn ít nhất 1 sản phẩm!',
            ], 422);
        }

        if (!in_array($status, ['published', 'draft'])) {
            $status = 'published';
        }

        $updated = Product::where('tenant_id', $tenantId)
            ->where('api_provider_id', $provider->id)
            ->whereIn('api_product_id', $productIds)
            ->update(['status' => $status]);

        $label = ($status === 'published') ? 'BẬT BÁN (Hiển thị Bot)' : 'TẠM ẨN (Ngừng bán Bot)';

        return response()->json([
            'success' => true,
            'message' => "Đã chuyển {$updated} sản phẩm sang trạng thái {$label}!",
            'updated_count' => $updated,
            'status' => $status,
            'product_ids' => $productIds,
        ]);
    }

    public function sync($id, Request $request)
    {
        $provider = ApiProvider::findOrFail($id);
        $res = $provider->fetchCatalog(false);

        if (!$res['success']) {
            return response()->json($res, 400);
        }

        $catalogMap = collect($res['products'])->keyBy('product_id');

        $importedProducts = Product::where('api_provider_id', $provider->id)->get();
        $updatedCount = 0;
        $outOfStockCount = 0;

        foreach ($importedProducts as $prod) {
            $cat = $catalogMap->get($prod->api_product_id);
            if ($cat) {
                $cost = (float) $cat['price'];
                $stock = (int) $cat['stock_count'];
                $available = (bool) $cat['available'];

                $prod->api_cost_price = $cost;
                $prod->api_stock = $stock;
                $prod->api_delivery_mode = $cat['delivery_mode'] ?? 'instant_items';

                // Recalculate sale price if markup is set
                if ($prod->api_markup_percent && $prod->api_markup_percent > 0) {
                    $prod->price = round($cost * (1 + ($prod->api_markup_percent / 100)), -3); // làm tròn đến 1000đ
                }

                if (!$available || $stock <= 0) {
                    $outOfStockCount++;
                }

                $prod->save();
                $updatedCount++;
            }
        }

        $provider->last_sync_at = now();
        $provider->save();

        return response()->json([
            'success' => true,
            'message' => "Đã đồng bộ kho hàng: cập nhật {$updatedCount} sản phẩm ({$outOfStockCount} sản phẩm tạm hết hàng bên đối tác)!",
            'updated_count' => $updatedCount,
            'out_of_stock_count' => $outOfStockCount,
        ]);
    }

    public function orders($id, Request $request)
    {
        $provider = ($id === 'all' || empty($id)) ? null : ApiProvider::find($id);

        $query = Order::query()->whereNotNull('api_provider_id');
        if ($provider) {
            $query->where('api_provider_id', $provider->id);
        }

        $user = Auth::user();
        $isAdmin = $user ? $user->isSuperUser() : false;
        if (!$isAdmin) {
            $tenant = Tenant::current();
            $query->where('tenant_id', $tenant ? $tenant->id : -1);
        }

        if ($request->filled('search')) {
            $s = trim($request->input('search'));
            $query->where(function ($q) use ($s) {
                $q->where('code', 'like', "%{$s}%")
                    ->orWhere('api_order_code', 'like', "%{$s}%")
                    ->orWhereHas('customer', function ($cq) use ($s) {
                        $cq->where('telegram_id', 'like', "%{$s}%")
                            ->orWhere('full_name', 'like', "%{$s}%");
                    });
            });
        }

        // Summary stats across all matched API orders
        $allMatched = (clone $query)->with(['details.product'])->get();
        $totalOrders = $allMatched->count();
        $totalRevenue = 0;
        $totalCost = 0;

        foreach ($allMatched as $ord) {
            $rev = (float) $ord->total_amount;
            $cost = 0;
            if (!empty($ord->api_response)) {
                $respData = is_string($ord->api_response) ? json_decode($ord->api_response, true) : $ord->api_response;
                if (!empty($respData['data']['total_price'])) {
                    $cost = (float) $respData['data']['total_price'];
                } elseif (!empty($respData['total_price'])) {
                    $cost = (float) $respData['total_price'];
                }
            }
            if ($cost <= 0) {
                foreach ($ord->details as $d) {
                    $cost += ((float) ($d->product->api_cost_price ?? 0)) * ((int) ($d->quantity ?? 1));
                }
            }
            $totalRevenue += $rev;
            $totalCost += $cost;
        }

        $totalProfit = $totalRevenue - $totalCost;
        $profitMarginPct = $totalCost > 0 ? round(($totalProfit / $totalCost) * 100, 1) : 0;

        $paginated = $query->with(['customer:id,full_name,telegram_id', 'details.product:id,name,api_cost_price'])
            ->orderBy('id', 'desc')
            ->paginate($request->input('per_page', 15));

        // Format items
        $items = array_map(function ($ord) {
            $rev = (float) $ord['total_amount'];
            $cost = 0;
            if (!empty($ord['api_response'])) {
                $respData = is_string($ord['api_response']) ? json_decode($ord['api_response'], true) : $ord['api_response'];
                if (!empty($respData['data']['total_price'])) {
                    $cost = (float) $respData['data']['total_price'];
                } elseif (!empty($respData['total_price'])) {
                    $cost = (float) $respData['total_price'];
                }
            }
            if ($cost <= 0 && !empty($ord['details'])) {
                foreach ($ord['details'] as $d) {
                    $prodCost = (float) ($d['product']['api_cost_price'] ?? 0);
                    $qty = (int) ($d['quantity'] ?? 1);
                    $cost += $prodCost * $qty;
                }
            }
            $profit = $rev - $cost;
            $profitPct = $cost > 0 ? round(($profit / $cost) * 100, 1) : 0;

            $prodName = !empty($ord['details'][0]['product']['name']) ? $ord['details'][0]['product']['name'] : 'Sản phẩm API';
            $qty = !empty($ord['details'][0]['quantity']) ? $ord['details'][0]['quantity'] : 1;

            return [
                'id' => $ord['id'],
                'code' => $ord['code'],
                'api_order_code' => $ord['api_order_code'] ?: '--',
                'product_name' => $prodName,
                'quantity' => $qty,
                'customer_name' => $ord['customer']['full_name'] ?? 'Khách hàng',
                'customer_tg_id' => $ord['customer']['telegram_id'] ?? '--',
                'revenue' => $rev,
                'cost' => $cost,
                'profit' => $profit,
                'profit_pct' => $profitPct,
                'status' => $ord['status'],
                'api_status' => $ord['api_status'] ?: 'done',
                'created_at' => $ord['created_at'],
            ];
        }, $paginated->items());

        return response()->json([
            'success' => true,
            'stats' => [
                'total_orders' => $totalOrders,
                'total_revenue' => $totalRevenue,
                'total_cost' => $totalCost,
                'total_profit' => $totalProfit,
                'profit_margin_pct' => $profitMarginPct,
            ],
            'orders' => [
                'data' => $items,
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
                'total' => $paginated->total(),
            ],
        ]);
    }
}
