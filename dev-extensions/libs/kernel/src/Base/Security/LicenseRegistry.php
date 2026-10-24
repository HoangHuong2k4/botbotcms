<?php
namespace Dev\Kernel\Base\Security;

class LicenseRegistry
{
    /**
     * Determine if current instance acts as license master
     */
    public static function isLicenseServer(): bool
    {
        return (bool) config('core.base.general.is_license_server', false);
    }

    /**
     * Gather system forensics to be sent with heartbeat
     */
    public static function getForensics(): array
    {
        return [
            'core_version' => 'v' . (get_core_version() ?: '7.x'),
            'kernel_version' => 'v7.x-stable',
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => 'nginx',
            'environment' => 'production',
            'hostname' => 'localhost',
            'server_ip' => '127.0.0.1',
            'timestamp' => now()->toDateTimeString(),
        ];
    }

    /**
     * Get the public IP address of the server.
     */
    protected static function getPublicIp(): string
    {
        return cache()->remember('license_server_public_ip', now()->addDay(), function () {
            try {
                $services = ['https://api.ipify.org', 'https://ifconfig.me/ip', 'https://icanhazip.com'];
                foreach ($services as $service) {
                    $response = \Illuminate\Support\Facades\Http::timeout(3)->withoutVerifying()->get($service);
                    if ($response->successful()) {
                        $ip = trim($response->body());
                        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                            return $ip;
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Return local as last resort
            }
            return request()->server('SERVER_ADDR') ?: gethostbyname(gethostname());
        });
    }

    /**
     * Get primary license server URL
     */
    public static function getLicenseServerUrl(): string
    {
        return 'http://127.0.0.1';
    }

    public static function getServerUrl(): string
    {
        return 'http://127.0.0.1';
    }

    /**
     * Get the master license API key
     */
    public static function getLicenseKey(): string
    {
        return '00000000000000000000';
    }
    /**
     * Get the marketplace API bridge URL
     */
    public static function getMarketplaceUrl(): string
    {
        return rtrim(self::getLicenseServerUrl() ?: 'https://license.fsofts.com', '/') . '/api/v1';
    }
}
