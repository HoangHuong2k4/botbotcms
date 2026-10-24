<?php

namespace Dev\Telehub\Commands;

use Illuminate\Console\Command;
use Dev\Telehub\Models\BotCustomer;
use Dev\Base\Enums\BaseStatusEnum;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CleanInactiveCustomersCommand extends Command
{
    protected $signature = 'telehub:clean-inactive-customers {--days=60 : Số ngày không tương tác} {--dry-run : Chỉ kiểm tra số lượng mà không xóa}';

    protected $description = 'Dọn dẹp các tài khoản khách hàng đã chặn bot hoặc không hoạt động sau số ngày quy định (chỉ xóa user có 0 số dư và chưa từng mua hàng/nạp tiền)';

    public function handle(): int
    {
        $days = (int) $this->option('days') ?: 60;
        $dryRun = $this->option('dry-run');
        $cutoffDate = Carbon::now()->subDays($days);

        $this->info("Bắt đầu quét khách hàng không hoạt động (> {$days} ngày)...");
        $this->info("Thời điểm mốc: {$cutoffDate->toDateTimeString()}");

        // Tìm khách hàng có số dư <= 0, không có đơn hàng, không có yêu cầu nạp tiền
        $query = BotCustomer::query()
            ->where('balance', '<=', 0)
            ->whereDoesntHave('orders')
            ->whereDoesntHave('depositRequests')
            ->where(function ($q) use ($cutoffDate) {
                // Trường hợp 1: Đã bị đánh dấu draft (chặn bot)
                $q->where('status', BaseStatusEnum::DRAFT)
                  // Trường hợp 2: Không có hoạt động gần đây
                  ->orWhere(function ($sub) use ($cutoffDate) {
                      $sub->where(function ($dateQ) use ($cutoffDate) {
                          $dateQ->whereNull('created_at')
                                ->orWhere('created_at', '<=', $cutoffDate);
                      })
                      ->where(function ($updQ) use ($cutoffDate) {
                          $updQ->whereNull('updated_at')
                               ->orWhere('updated_at', '<=', $cutoffDate);
                      })
                      ->whereNotExists(function ($actQ) use ($cutoffDate) {
                          $actQ->select(DB::raw(1))
                               ->from('telehub_customer_activities')
                               ->whereColumn('telehub_customer_activities.customer_id', 'telehub_bot_customers.id')
                               ->where('telehub_customer_activities.last_seen_at', '>', $cutoffDate);
                      });
                  });
            });

        $totalFound = $query->count();

        if ($totalFound === 0) {
            $this->info("Không tìm thấy khách hàng nào thỏa mãn điều kiện dọn dẹp.");
            return 0;
        }

        $this->warn("Tìm thấy {$totalFound} khách hàng không hoạt động (0 số dư, 0 đơn hàng, không vào bot > {$days} ngày hoặc đã chặn bot).");

        if ($dryRun) {
            $this->info("[Dry Run] Kết thúc chế độ chạy thử, chưa xóa dữ liệu nào.");
            return 0;
        }

        $deletedCount = 0;
        // Xóa theo batch 200 để tối ưu bộ nhớ
        $query->chunkById(200, function ($customers) use (&$deletedCount) {
            $ids = $customers->pluck('id')->toArray();

            DB::table('telehub_customer_activities')->whereIn('customer_id', $ids)->delete();
            DB::table('telehub_dealer_prices')->whereIn('customer_id', $ids)->delete();
            $deleted = BotCustomer::whereIn('id', $ids)->delete();

            $deletedCount += $deleted;
            $this->line("Đã xóa batch {$deleted} người dùng...");
        });

        $this->info("Hoàn tất! Tổng cộng đã dọn dẹp {$deletedCount} người dùng không hoạt động.");
        return 0;
    }
}
