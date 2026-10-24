<?php

namespace Dev\Telehub\Http\Controllers;

use Carbon\Carbon;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Telehub\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * User Analytics — behaviour of Telegram bot users:
 * active rate (week / month), purchase hours, conversion, top buyers, top API buyers…
 *
 * "Active" = a customer who did ANY of these in the window:
 *   - interacted with the bot (telehub_customer_activities, tracked from 04/10/2026)
 *   - created an order (bot or API)
 *   - created a deposit request
 *
 * Revenue rules match StatisticsController: status = completed, type != warranty, created_at NOT NULL.
 */
class UserAnalyticsController extends BaseController
{
    private ?int $tenantId = null;
    private bool $hasActivityTable = false;

    public function index(Request $request)
    {
        $this->pageTitle('Thống kê người dùng (User Analytics)');

        $isAdmin = Auth::user()->isSuperUser();
        $tenants = $isAdmin
            ? Tenant::withoutGlobalScopes()->select('id', 'username', 'email')->get()
            : collect();

        return view('plugins/telehub::user-analytics', compact('isAdmin', 'tenants'));
    }

    public function api(Request $request)
    {
        $user    = Auth::user();
        $isAdmin = $user->isSuperUser();

        if (!$isAdmin) {
            $tenant = Tenant::current();
            $this->tenantId = $tenant ? (int) $tenant->id : -1;
        } elseif ($request->filled('tenant_id')) {
            $this->tenantId = (int) $request->input('tenant_id');
        }

        $this->hasActivityTable = Schema::hasTable('telehub_customer_activities');

        $end   = $request->filled('date_to')
            ? Carbon::parse($request->input('date_to'))->endOfDay()
            : Carbon::now()->endOfDay();
        $start = $request->filled('date_from')
            ? Carbon::parse($request->input('date_from'))->startOfDay()
            : $end->copy()->subDays(29)->startOfDay();

        if ($start->gt($end)) {
            [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
        }

        $action = $request->input('action');
        if ($action === 'buyers') {
            $res = $this->topBuyers($start, $end, $request);
            return response()->json([
                'data' => $res['data'],
                'pagination' => $res['pagination'],
            ]);
        }

        if ($action === 'api_buyers') {
            $res = $this->topApiBuyers($start, $end, $request);
            return response()->json([
                'data' => $res['data'],
                'pagination' => $res['pagination'],
            ]);
        }

        $days      = $start->diffInDays($end) + 1;
        $prevEnd   = $start->copy()->subSecond();
        $prevStart = $prevEnd->copy()->subDays($days - 1)->startOfDay();

        $current  = $this->periodKpis($start, $end);
        $previous = $this->periodKpis($prevStart, $prevEnd);

        $now        = Carbon::now();
        $totalUsers = $this->totalUsers();
        $active7    = $this->activeCount($now->copy()->subDays(6)->startOfDay(), $now->copy()->endOfDay());
        $active30   = $this->activeCount($now->copy()->subDays(29)->startOfDay(), $now->copy()->endOfDay());
        $activeToday = $this->activeCount($now->copy()->startOfDay(), $now->copy()->endOfDay());

        $topBuyersRes = $this->topBuyers($start, $end, $request);
        $topApiRes    = $this->topApiBuyers($start, $end, $request);

        return response()->json(['data' => [
            'range' => [
                'from'      => $start->toDateString(),
                'to'        => $end->toDateString(),
                'days'      => $days,
                'prev_from' => $prevStart->toDateString(),
                'prev_to'   => $prevEnd->toDateString(),
            ],
            'tracking_since' => $this->trackingSince(),
            'overview' => [
                'total_users'  => $totalUsers,
                'total_dealers'=> $this->totalDealers(),
                'active_today' => $activeToday,
                'active_7d'    => $active7,
                'active_30d'   => $active30,
                'active_7d_pct'  => $this->pct($active7, $totalUsers),
                'active_30d_pct' => $this->pct($active30, $totalUsers),
                'stickiness'   => $this->pct($this->avgDailyActive($now->copy()->subDays(29)->startOfDay(), $now->copy()->endOfDay()), $active30),
                'buyers_ever'  => $this->buyersEver(),
            ],
            'current'  => $current,
            'previous' => $previous,
            'weekly'   => $this->weeklyTrend($totalUsers),
            'monthly'  => $this->monthlyTrend($totalUsers),
            'daily'    => $this->dailyTrend($start, $end),
            'hourly'   => $this->hourly($start, $end),
            'weekday'  => $this->weekday($start, $end),
            'heatmap'  => $this->heatmap($start, $end),
            'channels' => $this->channels($start, $end),
            'segments' => $this->segments($start, $end),
            'funnel'   => $this->funnel($start, $end),
            'top_buyers'            => $topBuyersRes['data'],
            'top_buyers_pagination' => $topBuyersRes['pagination'],
            'top_api'               => $topApiRes['data'],
            'top_api_pagination'    => $topApiRes['pagination'],
            'top_products' => $this->topProducts($start, $end),
            'at_risk'      => $this->atRisk(),
        ]]);
    }

    // ───────────────────────────── helpers ─────────────────────────────

    private function pct($part, $total): float
    {
        return $total > 0 ? round($part * 100 / $total, 2) : 0.0;
    }

    /** Returns [sql, bindings] fragment restricting a table alias to the tenant. */
    private function tenantWhere(string $alias): array
    {
        return $this->tenantId !== null ? [" AND {$alias}.tenant_id = ?", [$this->tenantId]] : ['', []];
    }

    private function revenueWhere(string $alias = 'o'): string
    {
        return "{$alias}.status = 'completed' AND {$alias}.type != 'warranty' AND {$alias}.created_at IS NOT NULL";
    }

    private function channelExpr(string $alias = 'o'): string
    {
        return "CASE WHEN {$alias}.code LIKE 'API%' THEN 'api' ELSE 'bot' END";
    }

    /**
     * Union of every "activity signal" in a window → (customer_id, d).
     */
    private function activitySource(Carbon $start, Carbon $end): array
    {
        [$tO, $bO] = $this->tenantWhere('o');
        [$tD, $bD] = $this->tenantWhere('dr');
        $s = $start->toDateTimeString();
        $e = $end->toDateTimeString();

        $sql = "SELECT o.customer_id, DATE(o.created_at) d FROM telehub_orders o
                  WHERE o.created_at BETWEEN ? AND ? {$tO}
                UNION ALL
                SELECT dr.customer_id, DATE(dr.created_at) d FROM telehub_deposit_requests dr
                  WHERE dr.created_at BETWEEN ? AND ? {$tD}";
        $bindings = array_merge([$s, $e], $bO, [$s, $e], $bD);

        if ($this->hasActivityTable) {
            [$tA, $bA] = $this->tenantWhere('a');
            $sql .= " UNION ALL
                SELECT a.customer_id, a.activity_date d FROM telehub_customer_activities a
                  WHERE a.activity_date BETWEEN ? AND ? {$tA}";
            $bindings = array_merge($bindings, [$start->toDateString(), $end->toDateString()], $bA);
        }

        return [$sql, $bindings];
    }

    private function activeCount(Carbon $start, Carbon $end): int
    {
        [$src, $b] = $this->activitySource($start, $end);
        return (int) (DB::selectOne("SELECT COUNT(DISTINCT customer_id) n FROM ({$src}) x", $b)->n ?? 0);
    }

    private function avgDailyActive(Carbon $start, Carbon $end): float
    {
        [$src, $b] = $this->activitySource($start, $end);
        $days = $start->diffInDays($end) + 1;
        $sum = DB::selectOne("SELECT IFNULL(SUM(n),0) s FROM (SELECT d, COUNT(DISTINCT customer_id) n FROM ({$src}) x GROUP BY d) y", $b)->s ?? 0;
        return $days > 0 ? $sum / $days : 0;
    }

    private function totalUsers(): int
    {
        [$t, $b] = $this->tenantWhere('c');
        return (int) DB::selectOne("SELECT COUNT(*) n FROM telehub_bot_customers c WHERE 1=1 {$t}", $b)->n;
    }

    private function totalDealers(): int
    {
        [$t, $b] = $this->tenantWhere('c');
        return (int) DB::selectOne("SELECT COUNT(*) n FROM telehub_bot_customers c WHERE c.is_dealer = 1 {$t}", $b)->n;
    }

    private function buyersEver(): int
    {
        [$t, $b] = $this->tenantWhere('o');
        return (int) DB::selectOne("SELECT COUNT(DISTINCT o.customer_id) n FROM telehub_orders o WHERE {$this->revenueWhere()} {$t}", $b)->n;
    }

    private function trackingSince(): ?string
    {
        if (!$this->hasActivityTable) {
            return null;
        }
        [$t, $b] = $this->tenantWhere('a');
        $row = DB::selectOne("SELECT MIN(a.activity_date) d FROM telehub_customer_activities a WHERE 1=1 {$t}", $b);
        return $row->d ?? null;
    }

    // ───────────────────────────── KPI blocks ─────────────────────────────

    private function periodKpis(Carbon $start, Carbon $end): array
    {
        [$t, $b] = $this->tenantWhere('o');
        $s = $start->toDateTimeString();
        $e = $end->toDateTimeString();

        $row = DB::selectOne(
            "SELECT COUNT(*) orders,
                    COUNT(DISTINCT o.customer_id) buyers,
                    IFNULL(SUM(o.total_amount),0) revenue,
                    IFNULL(SUM(CASE WHEN o.code LIKE 'API%' THEN o.total_amount ELSE 0 END),0) api_revenue,
                    SUM(o.code LIKE 'API%') api_orders,
                    COUNT(DISTINCT CASE WHEN o.code LIKE 'API%' THEN o.customer_id END) api_buyers
               FROM telehub_orders o
              WHERE {$this->revenueWhere()} AND o.created_at BETWEEN ? AND ? {$t}",
            array_merge([$s, $e], $b)
        );

        $refund = DB::selectOne(
            "SELECT IFNULL(SUM(w.refund_amount),0) r FROM telehub_warranties w
               JOIN telehub_orders o ON o.id = w.order_id
              WHERE w.type = 'refund' AND {$this->revenueWhere()} AND o.created_at BETWEEN ? AND ? {$t}",
            array_merge([$s, $e], $b)
        )->r;

        $repeat = DB::selectOne(
            "SELECT COUNT(*) n FROM (
                SELECT o.customer_id FROM telehub_orders o
                 WHERE {$this->revenueWhere()} AND o.created_at BETWEEN ? AND ? {$t}
                 GROUP BY o.customer_id HAVING COUNT(*) >= 2) x",
            array_merge([$s, $e], $b)
        )->n;

        // First-ever completed purchase falls inside this window
        $newBuyers = DB::selectOne(
            "SELECT COUNT(*) n FROM (
                SELECT o.customer_id, MIN(o.created_at) first_at FROM telehub_orders o
                 WHERE {$this->revenueWhere()} {$t}
                 GROUP BY o.customer_id) x
              WHERE x.first_at BETWEEN ? AND ?",
            array_merge($b, [$s, $e])
        )->n;

        $active  = $this->activeCount($start, $end);
        $orders  = (int) $row->orders;
        $buyers  = (int) $row->buyers;
        $revenue = (float) $row->revenue - (float) $refund;

        return [
            'active'        => $active,
            'buyers'        => $buyers,
            'new_buyers'    => (int) $newBuyers,
            'returning_buyers' => max(0, $buyers - (int) $newBuyers),
            'repeat_buyers' => (int) $repeat,
            'orders'        => $orders,
            'revenue'       => $revenue,
            'refund'        => (float) $refund,
            'aov'           => $orders ? round($revenue / $orders) : 0,
            'arpu'          => $buyers ? round($revenue / $buyers) : 0,
            'orders_per_buyer' => $buyers ? round($orders / $buyers, 2) : 0,
            'conversion'    => $this->pct($buyers, $active),
            'repeat_rate'   => $this->pct($repeat, $buyers),
            'api_orders'    => (int) $row->api_orders,
            'api_buyers'    => (int) $row->api_buyers,
            'api_revenue'   => (float) $row->api_revenue,
            'api_share'     => $this->pct((float) $row->api_revenue, (float) $row->revenue),
        ];
    }

    private function weeklyTrend(int $totalUsers): array
    {
        $end   = Carbon::now()->endOfWeek(Carbon::SUNDAY);
        $start = Carbon::now()->startOfWeek(Carbon::MONDAY)->subWeeks(11);
        [$src, $b] = $this->activitySource($start, $end);
        [$t, $bt] = $this->tenantWhere('o');

        $active = collect(DB::select(
            "SELECT YEARWEEK(d, 3) k, COUNT(DISTINCT customer_id) n FROM ({$src}) x GROUP BY k", $b
        ))->keyBy('k');

        $buyers = collect(DB::select(
            "SELECT YEARWEEK(o.created_at, 3) k, COUNT(DISTINCT o.customer_id) n, SUM(o.total_amount) rev
               FROM telehub_orders o WHERE {$this->revenueWhere()} AND o.created_at BETWEEN ? AND ? {$t} GROUP BY k",
            array_merge([$start->toDateTimeString(), $end->toDateTimeString()], $bt)
        ))->keyBy('k');

        $out = [];
        for ($w = $start->copy(); $w->lte($end); $w->addWeek()) {
            $k = (int) $w->format('oW');
            $a = (int) ($active[$k]->n ?? 0);
            $by = (int) ($buyers[$k]->n ?? 0);
            $out[] = [
                'label'   => $w->format('d/m') . ' – ' . $w->copy()->endOfWeek(Carbon::SUNDAY)->format('d/m'),
                'short'   => 'T' . $w->format('W'),
                'active'  => $a,
                'buyers'  => $by,
                'revenue' => (float) ($buyers[$k]->rev ?? 0),
                'active_pct' => $this->pct($a, $totalUsers),
                'conversion' => $this->pct($by, $a),
            ];
        }
        return $out;
    }

    private function monthlyTrend(int $totalUsers): array
    {
        $end   = Carbon::now()->endOfMonth();
        $start = Carbon::now()->startOfMonth()->subMonths(11);
        [$src, $b] = $this->activitySource($start, $end);
        [$t, $bt] = $this->tenantWhere('o');

        $active = collect(DB::select(
            "SELECT DATE_FORMAT(d, '%Y-%m') k, COUNT(DISTINCT customer_id) n FROM ({$src}) x GROUP BY k", $b
        ))->keyBy('k');

        $buyers = collect(DB::select(
            "SELECT DATE_FORMAT(o.created_at, '%Y-%m') k, COUNT(DISTINCT o.customer_id) n, SUM(o.total_amount) rev, COUNT(*) orders
               FROM telehub_orders o WHERE {$this->revenueWhere()} AND o.created_at BETWEEN ? AND ? {$t} GROUP BY k",
            array_merge([$start->toDateTimeString(), $end->toDateTimeString()], $bt)
        ))->keyBy('k');

        $out = [];
        for ($m = $start->copy(); $m->lte($end); $m->addMonth()) {
            $k = $m->format('Y-m');
            $a = (int) ($active[$k]->n ?? 0);
            $by = (int) ($buyers[$k]->n ?? 0);
            $out[] = [
                'label'   => $m->format('m/Y'),
                'active'  => $a,
                'buyers'  => $by,
                'orders'  => (int) ($buyers[$k]->orders ?? 0),
                'revenue' => (float) ($buyers[$k]->rev ?? 0),
                'active_pct' => $this->pct($a, $totalUsers),
                'conversion' => $this->pct($by, $a),
            ];
        }
        return $out;
    }

    private function dailyTrend(Carbon $start, Carbon $end): array
    {
        [$src, $b] = $this->activitySource($start, $end);
        [$t, $bt] = $this->tenantWhere('o');

        $active = collect(DB::select("SELECT d k, COUNT(DISTINCT customer_id) n FROM ({$src}) x GROUP BY d", $b))
            ->keyBy(fn ($r) => (string) $r->k);
        $orders = collect(DB::select(
            "SELECT DATE(o.created_at) k, COUNT(*) orders, COUNT(DISTINCT o.customer_id) buyers, SUM(o.total_amount) rev
               FROM telehub_orders o WHERE {$this->revenueWhere()} AND o.created_at BETWEEN ? AND ? {$t} GROUP BY k",
            array_merge([$start->toDateTimeString(), $end->toDateTimeString()], $bt)
        ))->keyBy(fn ($r) => (string) $r->k);

        $out = [];
        for ($d = $start->copy()->startOfDay(); $d->lte($end); $d->addDay()) {
            $k = $d->toDateString();
            $out[] = [
                'label'   => $d->format('d/m'),
                'active'  => (int) ($active[$k]->n ?? 0),
                'buyers'  => (int) ($orders[$k]->buyers ?? 0),
                'orders'  => (int) ($orders[$k]->orders ?? 0),
                'revenue' => (float) ($orders[$k]->rev ?? 0),
            ];
        }
        return $out;
    }

    private function hourly(Carbon $start, Carbon $end): array
    {
        [$t, $b] = $this->tenantWhere('o');
        $rows = collect(DB::select(
            "SELECT HOUR(o.created_at) h, COUNT(*) orders, COUNT(DISTINCT o.customer_id) buyers, SUM(o.total_amount) rev,
                    SUM(o.code LIKE 'API%') api_orders
               FROM telehub_orders o WHERE {$this->revenueWhere()} AND o.created_at BETWEEN ? AND ? {$t} GROUP BY h",
            array_merge([$start->toDateTimeString(), $end->toDateTimeString()], $b)
        ))->keyBy('h');

        $hits = collect();
        if ($this->hasActivityTable) {
            [$tA, $bA] = $this->tenantWhere('a');
            $hits = collect(DB::select(
                "SELECT a.activity_hour h, SUM(a.hits) hits, COUNT(DISTINCT a.customer_id) users
                   FROM telehub_customer_activities a WHERE a.activity_date BETWEEN ? AND ? {$tA} GROUP BY h",
                array_merge([$start->toDateString(), $end->toDateString()], $bA)
            ))->keyBy('h');
        }

        $totalOrders = max(1, $rows->sum('orders'));
        $out = [];
        for ($h = 0; $h < 24; $h++) {
            $o = (int) ($rows[$h]->orders ?? 0);
            $out[] = [
                'hour'       => $h,
                'label'      => sprintf('%02dh', $h),
                'orders'     => $o,
                'api_orders' => (int) ($rows[$h]->api_orders ?? 0),
                'buyers'     => (int) ($rows[$h]->buyers ?? 0),
                'revenue'    => (float) ($rows[$h]->rev ?? 0),
                'pct'        => round($o * 100 / $totalOrders, 2),
                'bot_hits'   => (int) ($hits[$h]->hits ?? 0),
                'bot_users'  => (int) ($hits[$h]->users ?? 0),
            ];
        }
        return $out;
    }

    private function weekday(Carbon $start, Carbon $end): array
    {
        [$t, $b] = $this->tenantWhere('o');
        $rows = collect(DB::select(
            "SELECT WEEKDAY(o.created_at) wd, COUNT(*) orders, COUNT(DISTINCT o.customer_id) buyers, SUM(o.total_amount) rev
               FROM telehub_orders o WHERE {$this->revenueWhere()} AND o.created_at BETWEEN ? AND ? {$t} GROUP BY wd",
            array_merge([$start->toDateTimeString(), $end->toDateTimeString()], $b)
        ))->keyBy('wd');

        $names = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'];
        $total = max(1, $rows->sum('orders'));
        $out = [];
        foreach ($names as $i => $n) {
            $o = (int) ($rows[$i]->orders ?? 0);
            $out[] = [
                'label'   => $n,
                'orders'  => $o,
                'buyers'  => (int) ($rows[$i]->buyers ?? 0),
                'revenue' => (float) ($rows[$i]->rev ?? 0),
                'pct'     => round($o * 100 / $total, 2),
            ];
        }
        return $out;
    }

    private function heatmap(Carbon $start, Carbon $end): array
    {
        [$t, $b] = $this->tenantWhere('o');
        $rows = DB::select(
            "SELECT WEEKDAY(o.created_at) wd, HOUR(o.created_at) h, COUNT(*) n
               FROM telehub_orders o WHERE {$this->revenueWhere()} AND o.created_at BETWEEN ? AND ? {$t} GROUP BY wd, h",
            array_merge([$start->toDateTimeString(), $end->toDateTimeString()], $b)
        );
        $grid = array_fill(0, 7, array_fill(0, 24, 0));
        foreach ($rows as $r) {
            $grid[(int) $r->wd][(int) $r->h] = (int) $r->n;
        }
        return $grid;
    }

    private function channels(Carbon $start, Carbon $end): array
    {
        [$t, $b] = $this->tenantWhere('o');
        $rows = DB::select(
            "SELECT {$this->channelExpr()} ch, COUNT(*) orders, COUNT(DISTINCT o.customer_id) buyers, SUM(o.total_amount) rev
               FROM telehub_orders o WHERE {$this->revenueWhere()} AND o.created_at BETWEEN ? AND ? {$t} GROUP BY ch",
            array_merge([$start->toDateTimeString(), $end->toDateTimeString()], $b)
        );
        $out = ['bot' => ['orders' => 0, 'buyers' => 0, 'revenue' => 0], 'api' => ['orders' => 0, 'buyers' => 0, 'revenue' => 0]];
        foreach ($rows as $r) {
            $out[$r->ch] = ['orders' => (int) $r->orders, 'buyers' => (int) $r->buyers, 'revenue' => (float) $r->rev];
        }
        return $out;
    }

    private function segments(Carbon $start, Carbon $end): array
    {
        [$t, $b] = $this->tenantWhere('o');
        $rows = DB::select(
            "SELECT CASE WHEN n = 1 THEN '1 đơn'
                         WHEN n BETWEEN 2 AND 3 THEN '2–3 đơn'
                         WHEN n BETWEEN 4 AND 10 THEN '4–10 đơn'
                         WHEN n BETWEEN 11 AND 50 THEN '11–50 đơn'
                         ELSE '50+ đơn' END seg,
                    MIN(n) sort_key, COUNT(*) customers, SUM(rev) revenue
               FROM (SELECT o.customer_id, COUNT(*) n, SUM(o.total_amount) rev FROM telehub_orders o
                      WHERE {$this->revenueWhere()} AND o.created_at BETWEEN ? AND ? {$t} GROUP BY o.customer_id) x
              GROUP BY seg ORDER BY sort_key",
            array_merge([$start->toDateTimeString(), $end->toDateTimeString()], $b)
        );
        return array_map(fn ($r) => [
            'label' => $r->seg, 'customers' => (int) $r->customers, 'revenue' => (float) $r->revenue,
        ], $rows);
    }

    private function funnel(Carbon $start, Carbon $end): array
    {
        $s = $start->toDateTimeString();
        $e = $end->toDateTimeString();
        [$tD, $bD] = $this->tenantWhere('dr');
        [$tO, $bO] = $this->tenantWhere('o');

        $depositors = (int) DB::selectOne(
            "SELECT COUNT(DISTINCT dr.customer_id) n FROM telehub_deposit_requests dr WHERE dr.created_at BETWEEN ? AND ? {$tD}",
            array_merge([$s, $e], $bD)
        )->n;
        $paid = (int) DB::selectOne(
            "SELECT COUNT(DISTINCT dr.customer_id) n FROM telehub_deposit_requests dr
              WHERE dr.status IN ('completed','success','paid','approved') AND dr.created_at BETWEEN ? AND ? {$tD}",
            array_merge([$s, $e], $bD)
        )->n;
        $buyers = (int) DB::selectOne(
            "SELECT COUNT(DISTINCT o.customer_id) n FROM telehub_orders o WHERE {$this->revenueWhere()} AND o.created_at BETWEEN ? AND ? {$tO}",
            array_merge([$s, $e], $bO)
        )->n;
        $repeat = (int) DB::selectOne(
            "SELECT COUNT(*) n FROM (SELECT o.customer_id FROM telehub_orders o
               WHERE {$this->revenueWhere()} AND o.created_at BETWEEN ? AND ? {$tO} GROUP BY o.customer_id HAVING COUNT(*) >= 2) x",
            array_merge([$s, $e], $bO)
        )->n;

        return [
            ['label' => 'Hoạt động trên bot', 'value' => $this->activeCount($start, $end)],
            ['label' => 'Tạo yêu cầu nạp',   'value' => $depositors],
            ['label' => 'Nạp thành công',     'value' => $paid],
            ['label' => 'Đã mua hàng',        'value' => $buyers],
            ['label' => 'Mua lặp lại (≥2 đơn)', 'value' => $repeat],
        ];
    }

    private function topBuyers(Carbon $start, Carbon $end, Request $request): array
    {
        [$t, $b] = $this->tenantWhere('o');
        $s = $start->toDateTimeString();
        $e = $end->toDateTimeString();

        $page = max(1, (int) $request->input('buyer_page', 1));
        $perPage = max(5, min(100, (int) $request->input('buyer_per_page', 15)));
        $search = trim((string) $request->input('buyer_search', ''));
        $sortBy = strtolower((string) $request->input('buyer_sort', 'revenue'));
        $sortDir = strtolower((string) $request->input('buyer_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $total = (float) DB::selectOne(
            "SELECT IFNULL(SUM(o.total_amount),0) s FROM telehub_orders o WHERE {$this->revenueWhere()} AND o.created_at BETWEEN ? AND ? {$t}",
            array_merge([$s, $e], $b)
        )->s;

        $searchWhere = '';
        $searchBindings = [];
        if ($search !== '') {
            $searchWhere = " AND (c.full_name LIKE ? OR c.username LIKE ? OR c.telegram_id LIKE ?)";
            $term = "%{$search}%";
            $searchBindings = [$term, $term, $term];
        }

        $role = (string) $request->input('buyer_role', 'all');
        if ($role === 'dealer') {
            $searchWhere .= " AND c.is_dealer = 1";
        } elseif ($role === 'retail') {
            $searchWhere .= " AND (c.is_dealer = 0 OR c.is_dealer IS NULL)";
        }

        // Count total matching unique buyers
        $countRow = DB::selectOne(
            "SELECT COUNT(DISTINCT c.id) as total
               FROM telehub_orders o
               JOIN telehub_bot_customers c ON c.id = o.customer_id
              WHERE {$this->revenueWhere()} AND o.created_at BETWEEN ? AND ? {$t} {$searchWhere}",
            array_merge([$s, $e], $b, $searchBindings)
        );
        $totalBuyers = (int) ($countRow->total ?? 0);

        // Map safe sort columns
        $orderCol = match ($sortBy) {
            'orders'     => 'orders',
            'qty'        => 'qty',
            'name'       => 'c.full_name',
            'balance'    => 'c.balance',
            'last_order' => 'last_order',
            default      => 'revenue',
        };

        $offset = ($page - 1) * $perPage;

        $rows = DB::select(
            "SELECT c.id, c.full_name, c.username, c.telegram_id, c.is_dealer, c.balance,
                    COUNT(*) orders, SUM(o.total_amount) revenue, IFNULL(SUM(q.qty),0) qty,
                    SUM(o.code LIKE 'API%') api_orders, MAX(o.created_at) last_order, MIN(o.created_at) first_order
               FROM telehub_orders o
               JOIN telehub_bot_customers c ON c.id = o.customer_id
               LEFT JOIN (SELECT order_id, SUM(quantity) qty FROM telehub_order_details GROUP BY order_id) q ON q.order_id = o.id
              WHERE {$this->revenueWhere()} AND o.created_at BETWEEN ? AND ? {$t} {$searchWhere}
              GROUP BY c.id, c.full_name, c.username, c.telegram_id, c.is_dealer, c.balance
              ORDER BY {$orderCol} {$sortDir}
              LIMIT ? OFFSET ?",
            array_merge([$s, $e], $b, $searchBindings, [$perPage, $offset])
        );

        $items = array_map(fn ($r) => [
            'id'          => $r->id,
            'name'        => $r->full_name ?: ('TG ' . $r->telegram_id),
            'username'    => $r->username && $r->username !== 'unknown' ? $r->username : null,
            'telegram_id' => (string) $r->telegram_id,
            'is_dealer'   => (bool) $r->is_dealer,
            'balance'     => (float) $r->balance,
            'orders'      => (int) $r->orders,
            'qty'         => (int) $r->qty,
            'revenue'     => (float) $r->revenue,
            'aov'         => $r->orders ? round($r->revenue / $r->orders) : 0,
            'api_orders'  => (int) $r->api_orders,
            'api_pct'     => $this->pct((int) $r->api_orders, (int) $r->orders),
            'share'       => $this->pct((float) $r->revenue, $total),
            'last_order'  => $r->last_order,
            'first_order' => $r->first_order,
        ], $rows);

        $lastPage = max(1, (int) ceil($totalBuyers / $perPage));

        return [
            'data' => $items,
            'pagination' => [
                'total'        => $totalBuyers,
                'per_page'     => $perPage,
                'current_page' => $page,
                'last_page'    => $lastPage,
                'from'         => $totalBuyers > 0 ? $offset + 1 : 0,
                'to'           => min($totalBuyers, $offset + count($items)),
            ],
        ];
    }

    private function topApiBuyers(Carbon $start, Carbon $end, Request $request): array
    {
        [$t, $b] = $this->tenantWhere('o');
        $s = $start->toDateTimeString();
        $e = $end->toDateTimeString();

        $page = max(1, (int) $request->input('api_page', 1));
        $perPage = max(5, min(100, (int) $request->input('api_per_page', 15)));
        $search = trim((string) $request->input('api_search', ''));
        $sortBy = strtolower((string) $request->input('api_sort', 'revenue'));
        $sortDir = strtolower((string) $request->input('api_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $total = (float) DB::selectOne(
            "SELECT IFNULL(SUM(o.total_amount),0) s FROM telehub_orders o
              WHERE {$this->revenueWhere()} AND o.code LIKE 'API%' AND o.created_at BETWEEN ? AND ? {$t}",
            array_merge([$s, $e], $b)
        )->s;

        $searchWhere = '';
        $searchBindings = [];
        if ($search !== '') {
            $searchWhere = " AND (c.full_name LIKE ? OR c.username LIKE ? OR c.telegram_id LIKE ?)";
            $term = "%{$search}%";
            $searchBindings = [$term, $term, $term];
        }

        $keyFilter = (string) $request->input('api_key_filter', 'all');
        if ($keyFilter === 'has_key') {
            $searchWhere .= " AND c.api_key IS NOT NULL AND c.api_key != ''";
        } elseif ($keyFilter === 'no_key') {
            $searchWhere .= " AND (c.api_key IS NULL OR c.api_key = '')";
        }

        $countRow = DB::selectOne(
            "SELECT COUNT(DISTINCT c.id) as total
               FROM telehub_orders o
               JOIN telehub_bot_customers c ON c.id = o.customer_id
              WHERE {$this->revenueWhere()} AND o.code LIKE 'API%' AND o.created_at BETWEEN ? AND ? {$t} {$searchWhere}",
            array_merge([$s, $e], $b, $searchBindings)
        );
        $totalApiBuyers = (int) ($countRow->total ?? 0);

        $orderCol = match ($sortBy) {
            'orders'      => 'orders',
            'qty'         => 'qty',
            'name'        => 'c.full_name',
            'balance'     => 'c.balance',
            'active_days' => 'active_days',
            'last_order'  => 'last_order',
            default       => 'revenue',
        };

        $offset = ($page - 1) * $perPage;

        $rows = DB::select(
            "SELECT c.id, c.full_name, c.username, c.telegram_id, c.balance, (c.api_key IS NOT NULL) has_key,
                    COUNT(*) orders, SUM(o.total_amount) revenue, IFNULL(SUM(q.qty),0) qty,
                    COUNT(DISTINCT DATE(o.created_at)) active_days, MAX(o.created_at) last_order,
                    (SELECT COUNT(DISTINCT d2.product_id) FROM telehub_order_details d2
                       JOIN telehub_orders o2 ON o2.id = d2.order_id
                      WHERE o2.customer_id = c.id AND o2.code LIKE 'API%' AND o2.created_at BETWEEN ? AND ?) products
               FROM telehub_orders o
               JOIN telehub_bot_customers c ON c.id = o.customer_id
               LEFT JOIN (SELECT order_id, SUM(quantity) qty FROM telehub_order_details GROUP BY order_id) q ON q.order_id = o.id
              WHERE {$this->revenueWhere()} AND o.code LIKE 'API%' AND o.created_at BETWEEN ? AND ? {$t} {$searchWhere}
              GROUP BY c.id, c.full_name, c.username, c.telegram_id, c.balance, c.api_key
              ORDER BY {$orderCol} {$sortDir}
              LIMIT ? OFFSET ?",
            array_merge([$s, $e, $s, $e], $b, $searchBindings, [$perPage, $offset])
        );

        $items = array_map(fn ($r) => [
            'id'          => $r->id,
            'name'        => $r->full_name ?: ('TG ' . $r->telegram_id),
            'username'    => $r->username && $r->username !== 'unknown' ? $r->username : null,
            'telegram_id' => (string) $r->telegram_id,
            'balance'     => (float) $r->balance,
            'has_key'     => (bool) $r->has_key,
            'orders'      => (int) $r->orders,
            'qty'         => (int) $r->qty,
            'revenue'     => (float) $r->revenue,
            'active_days' => (int) $r->active_days,
            'products'    => (int) $r->products,
            'share'       => $this->pct((float) $r->revenue, $total),
            'last_order'  => $r->last_order,
        ], $rows);

        $lastPage = max(1, (int) ceil($totalApiBuyers / $perPage));

        return [
            'data' => $items,
            'pagination' => [
                'total'        => $totalApiBuyers,
                'per_page'     => $perPage,
                'current_page' => $page,
                'last_page'    => $lastPage,
                'from'         => $totalApiBuyers > 0 ? $offset + 1 : 0,
                'to'           => min($totalApiBuyers, $offset + count($items)),
            ],
        ];
    }

    private function topProducts(Carbon $start, Carbon $end): array
    {
        [$t, $b] = $this->tenantWhere('o');
        $rows = DB::select(
            "SELECT p.id, p.name, COUNT(DISTINCT o.customer_id) buyers, COUNT(DISTINCT o.id) orders,
                    SUM(d.quantity) qty, SUM(o.total_amount) revenue,
                    SUM(o.code LIKE 'API%') api_orders
               FROM telehub_orders o
               JOIN telehub_order_details d ON d.order_id = o.id
               JOIN telehub_products p ON p.id = d.product_id
              WHERE {$this->revenueWhere()} AND o.created_at BETWEEN ? AND ? {$t}
              GROUP BY p.id, p.name ORDER BY buyers DESC, revenue DESC LIMIT 12",
            array_merge([$start->toDateTimeString(), $end->toDateTimeString()], $b)
        );
        return array_map(fn ($r) => [
            'name' => $r->name, 'buyers' => (int) $r->buyers, 'orders' => (int) $r->orders,
            'qty' => (int) $r->qty, 'revenue' => (float) $r->revenue, 'api_orders' => (int) $r->api_orders,
        ], $rows);
    }

    /** High-value customers who have not bought in the last 14 days. */
    private function atRisk(): array
    {
        [$t, $b] = $this->tenantWhere('o');
        $rows = DB::select(
            "SELECT c.id, c.full_name, c.username, c.telegram_id, c.is_dealer, c.balance,
                    COUNT(*) orders, SUM(o.total_amount) revenue, MAX(o.created_at) last_order,
                    DATEDIFF(NOW(), MAX(o.created_at)) days_since
               FROM telehub_orders o
               JOIN telehub_bot_customers c ON c.id = o.customer_id
              WHERE {$this->revenueWhere()} {$t}
              GROUP BY c.id, c.full_name, c.username, c.telegram_id, c.is_dealer, c.balance
             HAVING days_since >= 14 AND orders >= 2
              ORDER BY revenue DESC LIMIT 15",
            $b
        );
        return array_map(fn ($r) => [
            'name'        => $r->full_name ?: ('TG ' . $r->telegram_id),
            'username'    => $r->username && $r->username !== 'unknown' ? $r->username : null,
            'telegram_id' => (string) $r->telegram_id,
            'is_dealer'   => (bool) $r->is_dealer,
            'balance'     => (float) $r->balance,
            'orders'      => (int) $r->orders,
            'revenue'     => (float) $r->revenue,
            'last_order'  => $r->last_order,
            'days_since'  => (int) $r->days_since,
        ], $rows);
    }
}
