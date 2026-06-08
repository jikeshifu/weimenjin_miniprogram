<?php
namespace app\api\http\middleware;

class SafeCors
{
    public function handle($request, \Closure $next)
    {
        $origin = (string) $request->header('origin', '');
        if ($request->method() === 'OPTIONS') {
            $response = response('', 204);
        } else {
            $response = $next($request);
        }

        if ($origin !== '' && $this->isAllowedOrigin($origin, (string) $request->host())) {
            $response->header([
                'Access-Control-Allow-Origin' => $origin,
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Allow-Methods' => 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
                'Access-Control-Allow-Headers' => 'Authorization, Content-Type, X-CSRF-TOKEN, X-Requested-With',
                'Vary' => 'Origin',
            ]);
        }

        return $response;
    }

    private function isAllowedOrigin(string $origin, string $host): bool
    {
        $originHost = parse_url($origin, PHP_URL_HOST);
        if (!$originHost) {
            return false;
        }

        $allowed = array_filter([
            strtolower($host),
            strtolower((string) parse_url((string) config('my.siteconfig.siteurl', ''), PHP_URL_HOST)),
            'servicewechat.com',
        ]);

        $originHost = strtolower($originHost);
        foreach ($allowed as $allowedHost) {
            if ($originHost === $allowedHost || str_ends_with($originHost, '.' . $allowedHost)) {
                return true;
            }
        }
        return false;
    }
}
