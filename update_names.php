<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$products = [
    "ChatGPT Plus 1 Tháng VN BHF" => "ChatGPT Plus 1 Month VN Full Warranty",
    "Microsoft Office 365 1 năm 100k BHF" => "Microsoft Office 365 1 Year 100k Full Warranty",
    "Microsoft Office 365 5(2031) năm BH 1Năm" => "Microsoft Office 365 5 Years (2031) 1 Year Warranty",
    "Microsoft Office 365 date 2/2027" => "Microsoft Office 365 date 2/2027",
    "ChatGPT Plus UPI 1 Tháng BH7D" => "ChatGPT Plus UPI 1 Month 7D Warranty",
    "ChatGPT Plus UPI 1 tháng BHF" => "ChatGPT Plus UPI 1 Month Full Warranty",
    "ChatGPT Plus 1 Tháng VN BH24H" => "ChatGPT Plus 1 Month VN 24H Warranty",
    "ChatGPT Plus UPI 1 Tháng BH24H" => "ChatGPT Plus UPI 1 Month 24H Warranty",
    "Capcut Pro 1Tháng" => "Capcut Pro 1 Month",
    "Capcut Pro 7D BHF" => "Capcut Pro 7D Full Warranty",
    "Capcut Pro 14D BHF" => "Capcut Pro 14D Full Warranty",
    "Capcut Pro 6D BHF" => "Capcut Pro 6D Full Warranty",
    "Capcut Pro Team 1Tháng" => "Capcut Pro Team 1 Month",
    "Capcut Pro Team 35DAY" => "Capcut Pro Team 35 Days",
    "Grok Super 3Day" => "Grok Super 3 Days",
    "Admin Fam Capcut Pro 7D (10 SLOT)" => "Admin Fam Capcut Pro 7D (10 Slots)",
    "ChatGPT Plus PIX 1 Tháng BH24H" => "ChatGPT Plus PIX 1 Month 24H Warranty",
    "ChatGPT Plus PIX 1 Tháng BH7D" => "ChatGPT Plus PIX 1 Month 7D Warranty",
    "ChatGPT Plus PIX 1 tháng BHF" => "ChatGPT Plus PIX 1 Month Full Warranty"
];

$updated = 0;
foreach ($products as $viName => $enName) {
    $count = \Illuminate\Support\Facades\DB::table('telehub_products')->where('name', $viName)->update(['name_en' => $enName]);
    if ($count > 0) {
        $updated += $count;
        echo "Updated: $viName -> $enName\n";
    } else {
        echo "Not found: $viName\n";
    }
}
echo "Total updated: $updated\n";
