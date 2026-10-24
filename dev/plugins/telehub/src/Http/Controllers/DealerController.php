<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Telehub\Models\BotCustomer;
use Dev\Telehub\Models\DealerPrice;
use Dev\Telehub\Models\Product;
use Dev\Telehub\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Dev\Base\Facades\Assets;

class DealerController extends BaseController
{
    public function index(Request $request)
    {
        $this->pageTitle("Cộng Tác Viên (API)");
        Assets::usingVueJS();

        $user = Auth::user();
        $isAdmin = $user->isSuperUser();
        $tenantId = null;

        if (!$isAdmin) {
            if ($tenant = Tenant::current()) {
                $tenantId = $tenant->id;
            }
        }

        return view('plugins/telehub::dealers', compact('isAdmin', 'tenantId'));
    }

    public function getDealers(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->isSuperUser();
        $search = $request->input('search');

        $query = BotCustomer::where('is_dealer', true)->with('tenant');
        
        if (!$isAdmin) {
            if ($tenant = Tenant::current()) {
                $query->where('tenant_id', $tenant->id);
            }
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('telegram_id', 'like', "%{$search}%")
                  ->orWhere('api_key', 'like', "%{$search}%");
            });
        }

        $query->withCount(['orders' => function ($q) {
            $q->where('status', 'completed')->where('type', '!=', 'warranty');
        }])->withSum(['orders' => function ($q) {
            $q->where('status', 'completed')->where('type', '!=', 'warranty');
        }], 'total_amount')->orderBy('id', 'desc');

        $dealers = $query->paginate(20);
        return response()->json($dealers);
    }

    public function generateApiKey(Request $request, $id)
    {
        $customer = BotCustomer::findOrFail($id);
        $this->checkAccess($customer);

        $customer->api_key = 'DLR_' . Str::random(32);
        $customer->is_dealer = true;
        $customer->save();

        return response()->json(['success' => true, 'api_key' => $customer->api_key]);
    }

    public function toggleDealer(Request $request, $id)
    {
        $customer = BotCustomer::findOrFail($id);
        $this->checkAccess($customer);

        $isDealer = filter_var($request->input('is_dealer', true), FILTER_VALIDATE_BOOLEAN);
        $customer->is_dealer = $isDealer;
        if ($isDealer) {
            if (!$customer->api_key) {
                $customer->api_key = 'DLR_' . Str::random(32);
            }
        } else {
            // Khi hủy CTV, xóa api_key và tất cả giá sỉ đã set để tránh lỗi logic tồn dư
            $customer->api_key = null;
            DealerPrice::where('customer_id', $customer->id)->delete();
        }
        $customer->save();

        return response()->json(['success' => true]);
    }

    public function getDealerPrices(Request $request, $id)
    {
        $customer = BotCustomer::findOrFail($id);
        $this->checkAccess($customer);

        $products = Product::where('tenant_id', $customer->tenant_id)
            ->where('status', 'published')
            ->get();

        $prices = DealerPrice::where('customer_id', $id)->get()->keyBy('product_id');

        $data = $products->map(function ($product) use ($prices) {
            $dealerPrice = $prices->get($product->id);
            return [
                'product_id' => $product->id,
                'name' => $product->name,
                'retail_price' => $product->price,
                'retail_price_usd' => $product->price_usd,
                'dealer_price' => $dealerPrice ? $dealerPrice->price : null,
                'dealer_price_usd' => $dealerPrice ? $dealerPrice->price_usd : null,
            ];
        });

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function setDealerPrice(Request $request, $id)
    {
        $customer = BotCustomer::findOrFail($id);
        $this->checkAccess($customer);

        $request->validate([
            'product_id' => 'required|exists:telehub_products,id',
            'price' => 'nullable|numeric|min:0',
            'price_usd' => 'nullable|numeric|min:0',
        ]);

        $productId = $request->input('product_id');
        $price = $request->input('price');
        $priceUsd = $request->input('price_usd');

        if ((is_null($price) || $price === '') && (is_null($priceUsd) || $priceUsd === '')) {
            DealerPrice::where('customer_id', $id)->where('product_id', $productId)->delete();
        } else {
            DealerPrice::updateOrCreate(
                ['tenant_id' => $customer->tenant_id, 'customer_id' => $id, 'product_id' => $productId],
                ['price' => $price, 'price_usd' => $priceUsd]
            );
        }

        return response()->json(['success' => true]);
    }

    public function clearAllPrices(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->isSuperUser();

        if (!$isAdmin) {
            if ($tenant = Tenant::current()) {
                DealerPrice::where('tenant_id', $tenant->id)->delete();
            }
        } else {
            DealerPrice::query()->delete();
        }

        return response()->json(['success' => true]);
    }

    // Lấy tất cả customer để thêm vào CTV
    public function searchCustomers(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->isSuperUser();
        $search = $request->input('q');

        $query = BotCustomer::where('is_dealer', false);
        
        if (!$isAdmin) {
            if ($tenant = Tenant::current()) {
                $query->where('tenant_id', $tenant->id);
            }
        }

        if ($search) {
            $query->where('full_name', 'like', "%{$search}%")
                  ->orWhere('telegram_id', 'like', "%{$search}%");
        }

        $customers = $query->limit(20)->get();
        return response()->json(['success' => true, 'data' => $customers]);
    }

    public function getDealerStats(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->isSuperUser();
        $tenantId = null;

        if (!$isAdmin) {
            if ($tenant = Tenant::current()) {
                $tenantId = $tenant->id;
            }
        }

        // Top 5 Dealers by Revenue
        $dealerQuery = BotCustomer::where('is_dealer', true)
            ->withSum(['orders' => function ($q) {
                $q->where('status', 'completed')->where('type', '!=', 'warranty');
            }], 'total_amount')
            ->withCount(['orders' => function ($q) {
                $q->where('status', 'completed')->where('type', '!=', 'warranty');
            }]);

        if ($tenantId) {
            $dealerQuery->where('tenant_id', $tenantId);
        }

        $topDealers = $dealerQuery->get()
            ->sortByDesc('orders_sum_total_amount')
            ->take(5)
            ->values();

        // Top 5 Products bought by Dealers
        $productQuery = \Illuminate\Support\Facades\DB::table('telehub_order_details as od')
            ->join('telehub_orders as o', 'o.id', '=', 'od.order_id')
            ->join('telehub_bot_customers as c', 'c.id', '=', 'o.customer_id')
            ->join('telehub_products as p', 'p.id', '=', 'od.product_id')
            ->where('o.status', 'completed')
            ->where('o.type', '!=', 'warranty')
            ->where('c.is_dealer', true);

        if ($tenantId) {
            $productQuery->where('o.tenant_id', $tenantId);
        }

        $topProducts = $productQuery->select(
                'p.id as product_id',
                'p.name as product_name',
                \Illuminate\Support\Facades\DB::raw('SUM(od.quantity) as total_qty'),
                \Illuminate\Support\Facades\DB::raw('SUM(od.price * od.quantity) as total_revenue')
            )
            ->groupBy('p.id', 'p.name')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'top_dealers' => $topDealers,
            'top_products' => $topProducts
        ]);
    }

    public function getDealerPurchases(Request $request, $id)
    {
        $customer = BotCustomer::findOrFail($id);
        $this->checkAccess($customer);

        $purchases = \Illuminate\Support\Facades\DB::table('telehub_order_details as od')
            ->join('telehub_orders as o', 'o.id', '=', 'od.order_id')
            ->join('telehub_products as p', 'p.id', '=', 'od.product_id')
            ->where('o.customer_id', $id)
            ->where('o.status', 'completed')
            ->where('o.type', '!=', 'warranty')
            ->select(
                'p.id as product_id',
                'p.name as product_name',
                \Illuminate\Support\Facades\DB::raw('SUM(od.quantity) as total_qty'),
                \Illuminate\Support\Facades\DB::raw('SUM(od.price * od.quantity) as sub_total')
            )
            ->groupBy('p.id', 'p.name')
            ->orderByDesc('sub_total')
            ->get();

        return response()->json(['success' => true, 'data' => $purchases]);
    }

    private function checkAccess($customer)
    {
        $user = Auth::user();
        if (!$user->isSuperUser()) {
            if ($tenant = Tenant::current()) {
                if ($customer->tenant_id != $tenant->id) {
                    abort(403);
                }
            }
        }
    }
}
