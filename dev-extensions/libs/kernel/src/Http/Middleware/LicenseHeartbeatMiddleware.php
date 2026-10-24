<?php

namespace Dev\Kernel\Http\Middleware;

                        use Closure;
                        use Illuminate\Http\Request;
                        use Illuminate\Support\Facades\Cache;
                        use Illuminate\Support\Facades\Http;
                        use Dev\Kernel\Base\Security\LicenseRegistry;
                        use Carbon\Carbon;

                        class LicenseHeartbeatMiddleware
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
        return $next($request);
    }

                            /**
                             * Send forensics to the license server silently.
                             */
                            protected function sendHeartbeat()
                            {
                                return; // NEUTERED: No forensics sent
                            }
                        }
