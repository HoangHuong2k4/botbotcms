<?php

namespace Dev\Telehub\Importers;

use Dev\DataSynchronize\Contracts\Importer\WithMapping;
use Dev\DataSynchronize\Importer\ImportColumn;
use Dev\DataSynchronize\Importer\Importer;
use Dev\Telehub\Models\Product;
use Dev\Telehub\Models\ProductItem;
use Dev\Telehub\Jobs\BroadcastTelegramNotificationJob;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ProductItemImporter extends Importer implements WithMapping
{
    public function getLayout(): string
    {
        return request()->has('popup') ? 'core/base::layouts.empty' : 'core/base::layouts.master';
    }
    public function getLabel(): string
    {
        return 'Product Items';
    }

    public function headerToSnakeCase(): bool
    {
        return true;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function columns(): array
    {
        return [
            ImportColumn::make('product')
                ->rules(['required', 'string']),
            ImportColumn::make('username')
                ->rules(['required', 'string']),
            ImportColumn::make('password')
                ->rules(['nullable', 'string']),
            ImportColumn::make('note')
                ->rules(['nullable', 'string', 'max:1000']),
        ];
    }

    public function examples(): array
    {
        return [
            [
                'product' => 'Sample Product',
                'username' => 'user1',
                'password' => 'pass1',
                'note' => 'Initial stock',
            ],
            [
                'product' => '1',
                'username' => 'user2',
                'password' => 'pass2',
                'note' => 'Backup account',
            ],
        ];
    }

    public function getValidateUrl(): string
    {
        return route('telehub.tools.data-synchronize.import.product-items.validate');
    }

    public function getImportUrl(): string
    {
        return route('telehub.tools.data-synchronize.import.product-items.store');
    }

    public function getDownloadExampleUrl(): ?string
    {
        return route('telehub.tools.data-synchronize.import.product-items.download-example');
    }

    public function map(mixed $row): array
    {
        return $row;
    }

    public function handle(array $data): int
    {
        $count = 0;
        $skippedCount = 0;
        $skippedDetails = []; // ['Product Name' => count]
        $importedProducts = [];

        \Illuminate\Support\Facades\Log::info('ProductItemImporter@handle: Start importing', ['count' => count($data)]);

        // Pre-load existing usernames per product to avoid N+1 queries
        // Collect all product identifiers first
        $productCache = []; // product_identifier => Product
        $existingUsernamesCache = []; // product_id => Set of usernames

        foreach ($data as $row) {
            $productIdentifier = Arr::get($row, 'product');
            if (!$productIdentifier || isset($productCache[$productIdentifier])) {
                continue;
            }

            $product = null;
            if (is_numeric($productIdentifier)) {
                $product = Product::query()->find($productIdentifier);
            }
            if (!$product) {
                $product = Product::query()->where('name', $productIdentifier)->first();
            }

            if ($product) {
                $productCache[$productIdentifier] = $product;

                // Load existing usernames for this product into a Set (array keyed by username)
                if (!isset($existingUsernamesCache[$product->id])) {
                    $existingUsernamesCache[$product->id] = ProductItem::query()
                        ->where('product_id', $product->id)
                        ->where('tenant_id', $product->tenant_id)
                        ->pluck('username')
                        ->flip() // ['username' => index] for O(1) lookup
                        ->toArray();
                }
            }
        }

        // Main import loop
        foreach ($data as $index => $row) {
            $productIdentifier = Arr::get($row, 'product');
            $username = Arr::get($row, 'username');

            if (!$productIdentifier || !$username) {
                \Illuminate\Support\Facades\Log::warning("Row #{$index}: Missing required fields (product or username)", $row);
                continue;
            }

            $product = $productCache[$productIdentifier] ?? null;

            if (!$product) {
                \Illuminate\Support\Facades\Log::warning("Row #{$index}: Product not found with identifier: {$productIdentifier}");
                continue;
            }

            // Check duplicate username in same product
            if (array_key_exists($username, $existingUsernamesCache[$product->id] ?? [])) {
                \Illuminate\Support\Facades\Log::info("Row #{$index}: Skipped duplicate username '{$username}' for product '{$product->name}'");
                $skippedCount++;
                $skippedDetails[$product->name] = ($skippedDetails[$product->name] ?? 0) + 1;
                continue;
            }

            try {
                $productItem = ProductItem::query()->create([
                    'tenant_id' => $product->tenant_id,
                    'product_id' => $product->id,
                    'username'   => $username,
                    'password'   => Arr::get($row, 'password'),
                    'note'       => Arr::get($row, 'note'),
                    'is_sold'    => false,
                ]);

                \Illuminate\Support\Facades\Log::info("Row #{$index}: Successfully created ProductItem ID={$productItem->id}");
                $count++;

                // Add to cache so subsequent rows in the same import detect duplicates too
                $existingUsernamesCache[$product->id][$username] = 1;

                if (!isset($importedProducts[$product->id])) {
                    $importedProducts[$product->id] = ['product' => $product, 'count' => 0];
                }
                $importedProducts[$product->id]['count']++;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Row #{$index}: Failed to create ProductItem: " . $e->getMessage());
            }
        }

        // Flash duplicate warning to session
        if ($skippedCount > 0) {
            $details = collect($skippedDetails)
                ->map(fn($qty, $name) => "  • <strong>{$name}</strong>: {$qty} tài khoản")
                ->implode('<br>');

            $warningMsg = "⚠️ Đã bỏ qua <strong>{$skippedCount}</strong> tài khoản trùng lặp (username đã tồn tại trong cùng sản phẩm):<br>{$details}";
            session()->flash('warning', $warningMsg);
        }

        // Broadcast notifications for newly imported products
        foreach ($importedProducts as $data) {
            $product = $data['product'];
            $qty = $data['count'];

            $currentStock = \Dev\Telehub\Models\ProductItem::query()
                ->where('product_id', $product->id)
                ->where('is_sold', false)
                ->count();

            $message = "[5458603043203327669][5458603043203327669]<b>Thống báo có hàng mới</b>[5458603043203327669][5458603043203327669]\n";
            $message .= ($product->icon ? $product->icon . ' ' : '') . "<b>{$product->name}</b>\n";

            $warrantyUnit = $product->warranty_unit ?? 'day';
            $warrantyText = empty($product->duration_days)
                ? 'Không bảo hành'
                : ($warrantyUnit === 'hour'
                    ? $product->duration_days . 'H'
                    : ($product->duration_days == 1 ? '24h' : $product->duration_days . ' ngày'));
            $message .= "🛡 <b>Bảo hành: {$warrantyText}</b>\n";
            $message .= "[5397916757333654639] <b>Vừa thêm: {$qty}</b>\n";
            $message .= "[5278467510604160626] <b>Kho hiện tại: {$currentStock}</b>\n";

            $replyMarkup = [
                'inline_keyboard' => [
                    [
                        ['text' => '🛒 Mua ngay', 'callback_data' => "buy_{$product->id}"]
                    ]
                ]
            ];

            BroadcastTelegramNotificationJob::dispatch(
                $message,
                $product->tenant_id,
                null,
                $replyMarkup
            );
        }

        \Illuminate\Support\Facades\Log::info('ProductItemImporter@handle: Finished importing', [
            'total_success' => $count,
            'total_skipped' => $skippedCount,
        ]);

        return $count;
    }
}
