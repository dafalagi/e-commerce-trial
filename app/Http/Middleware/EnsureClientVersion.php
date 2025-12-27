<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureClientVersion
{
    /**
     * The current version of the API.
     *
     * @var string
     */
    protected string $current_api_version = '0.0.0';

    /**
     * The minimum version of the client required to access the API.
     *
     * @var string
     */
    protected string $minimum_admin_client_version = '0.0.0';
    protected string $minimum_web_client_version = '0.0.0';
    protected string $minimum_mobile_client_version = '0.0.0';

    /**
     * The maximum version of the client that can access the API.
     * The API will not accept any version higher than or equal to this.
     *
     * @var string
     */
    protected string $maximum_client_version = '1.0.0';

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $version = $request->header('X-Client-Version');

        if(!$version) {
            return response()->json([
                'message' => 'Client version header is missing.'
            ], 400);
        }

        if(!preg_match('/^\d+\.\d+\.\d+$/', $version)) {
            return response()->json([
                'message' => 'Invalid client version format.'
            ], 400);
        }

        $url = $request->url();
        preg_match('/\/v\d+\/(admin|web|mobile)\//', $url, $matches);
        $env = $matches[1] ?? 'admin';

        match($env) {
            'admin' => $minimum_client_version = $this->minimum_admin_client_version,
            'web' => $minimum_client_version = $this->minimum_web_client_version,
            'mobile' => $minimum_client_version = $this->minimum_mobile_client_version,
        };

        if(version_compare($version, $minimum_client_version, '<')) {
            return response()->json([
                'message' => 'Client version is too old. Please update to the latest version.'
            ], 426);
        }

        if(version_compare($version, $this->maximum_client_version, '>=')) {
            return response()->json([
                'message' => 'Client version is too new. Please downgrade to a supported version.'
            ], 426);
        }

        return $next($request);
    }
}
