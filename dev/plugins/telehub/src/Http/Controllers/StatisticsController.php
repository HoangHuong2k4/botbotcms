<?php

namespace Dev\Telehub\Http\Controllers;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Telehub\Models\BotCustomer;
use Dev\Telehub\Models\Order;
use Dev\Telehub\Models\Product;
use Dev\Telehub\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Dev\Base\Facades\Assets;

class StatisticsController extends BaseController
{
    public function index(Request $request)
    {
        $this->pageTitle("Revenue Statistics");

        Assets::usingVueJS();

        $user    = Auth::user();
        $isAdmin = $user->isSuperUser();

        // Tenant list for admin filter
        $tenants = collect();
        if ($isAdmin) {
            $tenants = Tenant::withoutGlobalScopes()->select("id", "username", "email")->get();
        }

        $dateFrom  = $request->input("date_from", "");
        $dateTo    = $request->input("date_to",   "");
        $monthYear = $request->input("month_year","");
        $tenantId  = $request->input("tenant_id", "");

        return view("plugins/telehub::statistics", compact(
            "isAdmin", "tenants",
            "dateFrom", "dateTo", "monthYear", "tenantId"
        ));
    }

    public function api(Request $request)
    {
        $user    = Auth::user();
        $isAdmin = $user->isSuperUser();

        // ─── Parse filters ────────────────────────────────────────────
        $dateFrom   = $request->input("date_from");
        $dateTo     = $request->input("date_to");
        $monthYear  = $request->input("month_year");
        $tenantId   = $request->input("tenant_id");
        $customerIds = $request->input("customer_id");
        $productIds  = $request->input("product_id");

        // Normalize to array
        if ($customerIds && !is_array($customerIds)) {
            $customerIds = explode(',', $customerIds);
        }
        if ($productIds && !is_array($productIds)) {
            $productIds = explode(',', $productIds);
        }

        if ($monthYear) {
            $dateFrom = Carbon::createFromFormat("Y-m", $monthYear)->startOfMonth()->toDateString();
            $dateTo   = Carbon::createFromFormat("Y-m", $monthYear)->endOfMonth()->toDateString();
        }

        $startDate = $dateFrom ? Carbon::parse($dateFrom)->startOfDay() : Carbon::now()->startOfMonth()->startOfDay();
        $endDate   = $dateTo   ? Carbon::parse($dateTo)->endOfDay()    : Carbon::now()->endOfDay();

        // ─── Base order query ─────────────────────────────────────────
        $baseQ = Order::from("telehub_orders")
            ->where("status", "completed")
            ->where("type", "!=", "warranty")
            ->whereBetween("telehub_orders.created_at", [$startDate, $endDate]);

        if (!$isAdmin) {
            if ($tenant = Tenant::current()) {
                $baseQ->where("telehub_orders.tenant_id", $tenant->id);
            }
        } elseif ($isAdmin && $tenantId) {
            $baseQ->where("telehub_orders.tenant_id", (int)$tenantId);
        }

        if (!empty($customerIds)) {
            $baseQ->whereIn("telehub_orders.customer_id", $customerIds);
        }

        if (!empty($productIds)) {
            $baseQ->whereExists(function ($q) use ($productIds) {
                $q->select(DB::raw(1))
                  ->from("telehub_order_details as od")
                  ->whereColumn("od.order_id", "telehub_orders.id")
                  ->whereIn("od.product_id", $productIds);
            });
        }

        $warrantiesSub = DB::table('telehub_warranties')
            ->where('type', 'refund')
            ->select('order_id', DB::raw('SUM(refund_amount) as total_refund'))
            ->groupBy('order_id');

        $totalRevRow = (clone $baseQ)
            ->leftJoinSub($warrantiesSub, 'w', 'w.order_id', '=', 'telehub_orders.id')
            ->selectRaw('SUM(telehub_orders.total_amount) - IFNULL(SUM(w.total_refund), 0) as total')
            ->first();
        $totalRevenue = $totalRevRow ? $totalRevRow->total : 0;
        
        $totalOrders  = (clone $baseQ)->count();

        // ─── Revenue by day ───────────────────────────────────────────
        $revenueByDay = (clone $baseQ)
            ->leftJoinSub($warrantiesSub, 'w', 'w.order_id', '=', 'telehub_orders.id')
            ->select(DB::raw("DATE(telehub_orders.created_at) as date"), DB::raw("SUM(telehub_orders.total_amount) - IFNULL(SUM(w.total_refund), 0) as total"))
            ->groupBy("date")
            ->orderBy("date", "asc")
            ->get();

        // ─── Per-customer x product stats ─────────────────────────────
        $cpBase = DB::table("telehub_orders as o")
            ->join("telehub_bot_customers as c", "c.id", "=", "o.customer_id")
            ->join("telehub_order_details as od", "od.order_id", "=", "o.id")
            ->join("telehub_products as p", "p.id", "=", "od.product_id")
            ->where("o.status", "completed")
            ->where("o.type", "!=", "warranty")
            ->whereBetween("o.created_at", [$startDate, $endDate]);

        if (!$isAdmin) {
            if ($tenant = Tenant::current()) {
                $cpBase->where("o.tenant_id", $tenant->id);
            }
        } elseif ($isAdmin && $tenantId) {
            $cpBase->where("o.tenant_id", (int)$tenantId);
        }
        if (!empty($customerIds)) {
            $cpBase->whereIn("c.id", $customerIds);
        }
        if (!empty($productIds)) {
            $cpBase->whereIn("p.id", $productIds);
        }
        $warrantiesProductSub = DB::table('telehub_warranties as w')
            ->join('telehub_product_items as i', 'i.id', '=', 'w.product_item_id')
            ->where('w.type', 'refund')
            ->select('w.order_id', 'i.product_id', DB::raw('SUM(w.refund_amount) as total_refund'))
            ->groupBy('w.order_id', 'i.product_id');

        $rows = (clone $cpBase)
            ->leftJoinSub($warrantiesProductSub, 'wp', function($join) {
                $join->on('wp.order_id', '=', 'o.id')
                     ->on('wp.product_id', '=', 'p.id');
            })
            ->select(
                "c.id as customer_id", "c.full_name", "c.telegram_id", "o.tenant_id",
                "p.id as product_id", "p.name as product_name",
                DB::raw("SUM(od.quantity) as total_qty"),
                DB::raw("SUM(o.total_amount) - IFNULL(SUM(wp.total_refund), 0) as sub_total"),
                DB::raw("MAX(od.price_usd) as unit_price_usd"),
                DB::raw("MAX(od.price) as unit_price_vnd")
            )
            ->groupBy("c.id", "c.full_name", "c.telegram_id", "o.tenant_id", "p.id", "p.name")
            ->orderBy("sub_total", "desc")
            ->get();

        $customerStats = [];
        foreach ($rows as $row) {
            if (!isset($customerStats[$row->customer_id])) {
                $customerStats[$row->customer_id] = [
                    "customer_id" => $row->customer_id,
                    "full_name"   => $row->full_name ?: "TG: " . $row->telegram_id,
                    "telegram_id" => $row->telegram_id,
                    "tenant_id"   => $row->tenant_id,
                    "grand_total" => 0,
                    "products"    => [],
                ];
            }
            $customerStats[$row->customer_id]["grand_total"] += $row->sub_total;
            $customerStats[$row->customer_id]["products"][]   = [
                "product_id"     => $row->product_id,
                "product_name"   => $row->product_name,
                "total_qty"      => $row->total_qty,
                "sub_total"      => $row->sub_total,
                "unit_price_usd" => $row->unit_price_usd ? (float)$row->unit_price_usd : null,
                "unit_price_vnd" => (float)$row->unit_price_vnd,
            ];
        }
        usort($customerStats, fn($a, $b) => $b["grand_total"] <=> $a["grand_total"]);

        // ─── Top products ─────────────────────────────────────────────
        $topProducts = (clone $cpBase)
            ->leftJoinSub($warrantiesProductSub, 'wp', function($join) {
                $join->on('wp.order_id', '=', 'o.id')
                     ->on('wp.product_id', '=', 'p.id');
            })
            ->select(
                "p.id as product_id", "p.name as product_name",
                DB::raw("SUM(od.quantity) as total_qty"),
                DB::raw("SUM(o.total_amount) - IFNULL(SUM(wp.total_refund), 0) as total_revenue")
            )
            ->groupBy("p.id", "p.name")
            ->orderBy("total_revenue", "desc")
            ->limit(10)->get();

        // ─── Admin tenant stats ───────────────────────────────────────
        $tenantStats = collect();
        if ($isAdmin) {
            $tenants = Tenant::withoutGlobalScopes()->select("id", "username", "email")->get();
            $tenantRevs = DB::table("telehub_orders")
                ->where("status", "completed")
                ->where("type", "!=", "warranty")
                ->whereBetween("created_at", [$startDate, $endDate])
                ->leftJoinSub($warrantiesSub, 'w', 'w.order_id', '=', 'telehub_orders.id')
                ->select("tenant_id", DB::raw("SUM(total_amount) - IFNULL(SUM(w.total_refund), 0) as revenue"), DB::raw("COUNT(*) as orders_count"))
                ->groupBy("tenant_id")->get()->keyBy("tenant_id");
            foreach ($tenants as $t) {
                $t->period_revenue = $tenantRevs[$t->id]->revenue      ?? 0;
                $t->period_orders  = $tenantRevs[$t->id]->orders_count ?? 0;
            }
            $tenantStats = $tenants->sortByDesc("period_revenue")->values();
        }

        // ─── All customers (for filter dropdown) ─────────────────────
        $allCustomersQ = BotCustomer::select("id", "full_name", "telegram_id");
        if (!$isAdmin) {
            if ($tenant = Tenant::current()) {
                $allCustomersQ->where("tenant_id", $tenant->id);
            }
        } elseif ($isAdmin && $tenantId) {
            $allCustomersQ->where("tenant_id", (int)$tenantId);
        }
        $allCustomers = $allCustomersQ->orderBy("full_name")->get();

        // ─── All products (for filter dropdown) ───────────────────────
        $allProductsQ = Product::select("id", "name", "price");
        if (!$isAdmin) {
            if ($tenant = Tenant::current()) {
                $allProductsQ->where("tenant_id", $tenant->id);
            }
        } elseif ($isAdmin && $tenantId) {
            $allProductsQ->where("tenant_id", (int)$tenantId);
        }
        $allProducts = $allProductsQ->orderBy("name")->get();

        // ─── Combo analytics ──────────────────────────────────────────
        $comboStatsQ = DB::table('telehub_order_details as od')
            ->join('telehub_orders as o', 'o.id', '=', 'od.order_id')
            ->join('telehub_product_combos as pc', 'pc.id', '=', 'od.combo_id')
            ->where('o.status', 'completed')
            ->where('o.type', '!=', 'warranty')
            ->whereNotNull('od.combo_id')
            ->whereBetween('o.created_at', [$startDate, $endDate]);

        if (!$isAdmin) {
            if ($tenant = Tenant::current()) {
                $comboStatsQ->where('o.tenant_id', $tenant->id);
            }
        } elseif ($isAdmin && $tenantId) {
            $comboStatsQ->where('o.tenant_id', (int)$tenantId);
        }

        $comboStats = (clone $comboStatsQ)
            ->select(
                'pc.id as combo_id',
                'pc.type as combo_type',
                'pc.min_quantity',
                'pc.discount_percent',
                'pc.discount_amount',
                'pc.bonus_qty as combo_bonus_qty',
                'pc.label',
                DB::raw("COUNT(od.id) as usage_count"),
                DB::raw("SUM(od.quantity) as total_acc_sold"),
                DB::raw("SUM(od.bonus_qty) as total_bonus_given"),
                DB::raw("SUM(o.total_amount) as combo_revenue")
            )
            ->groupBy('pc.id', 'pc.type', 'pc.min_quantity', 'pc.discount_percent', 'pc.discount_amount', 'pc.bonus_qty', 'pc.label')
            ->orderBy('usage_count', 'desc')
            ->get();

        // Tổng orders dùng combo vs không dùng combo
        $totalComboOrders = (clone $comboStatsQ)->count();
        $totalBonusGiven = (clone $comboStatsQ)->sum('od.bonus_qty');

        return response()->json(["data" => [
            "total_revenue"      => (float)$totalRevenue,
            "total_orders"       => (int)$totalOrders,
            "chart_labels"       => $revenueByDay->map(fn($r) => Carbon::parse($r->date)->format("d/m"))->values(),
            "chart_data"         => $revenueByDay->pluck("total")->map(fn($v) => (float)$v)->values(),
            "customer_stats"     => array_values($customerStats),
            "top_products"       => $topProducts,
            "tenant_stats"       => $tenantStats,
            "all_customers"      => $allCustomers,
            "all_products"       => $allProducts,
            "combo_stats"        => $comboStats,
            "total_combo_orders" => (int)$totalComboOrders,
            "total_bonus_given"  => (int)($totalBonusGiven ?? 0),
        ]]);
    }
}

