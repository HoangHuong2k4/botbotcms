<?php

namespace Dev\Telehub\Http\Middleware;

use Closure;
use Dev\Telehub\Models\Tenant;
use Illuminate\Http\Request;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        $baseDomain = config('app.domain', 'cms-tele.test');

        // Check if the current host is a subdomain of the base domain
        if ($host !== $baseDomain && str_ends_with($host, '.' . $baseDomain)) {
            $subdomain = str_replace('.' . $baseDomain, '', $host);

            // Handle nested subdomains if any (e.g., www.tenant1)
            $parts = explode('.', $subdomain);
            $tenantHandle = end($parts);

            if ($tenantHandle && $tenantHandle !== 'www') {
                $tenant = Tenant::where('username', $tenantHandle)
                    ->where('status', 'published')
                    ->first();

                if (!$tenant) {
                    abort(404, 'Tenant not found or inactive.');
                }

                // Bind the tenant to the container for easy access
                app()->instance('tenant', $tenant);
            }
        }

        return $next($request);
    }
}
