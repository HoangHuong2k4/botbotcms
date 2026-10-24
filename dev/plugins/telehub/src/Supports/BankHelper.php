<?php

namespace Dev\Telehub\Supports;

class BankHelper
{
    public static function getBanks(): array
    {
        return \Illuminate\Support\Facades\Cache::remember('vietqr_banks', 86400, function () {
            try {
                $response = \Illuminate\Support\Facades\Http::get('https://api.vietqr.io/v2/banks');
                if ($response->successful()) {
                    $banks = $response->json('data');
                    $result = [];
                    foreach ($banks as $bank) {
                        $result[$bank['code']] = "{$bank['code']} - {$bank['shortName']}";
                    }
                    // Add manual VTLMONEY if not in list
                    if (!isset($result['VTLMONEY'])) {
                        $result['VTLMONEY'] = 'VTLMONEY - Viettel Money';
                    }
                    return $result;
                }
            } catch (\Exception $e) {
                // Fallback to minimal list
            }

            return [
                'TPB' => 'TPB - TPBank',
                'MB' => 'MB - MBBank',
                'VCB' => 'VCB - Vietcombank',
                'VTLMONEY' => 'VTLMONEY - Viettel Money',
            ];
        });
    }
}
