<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;

class Configuration
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $configs = Config::get('app');
        $baleomolTokenAuth = Cache::get('baleomol_token_auth');
        if(empty($baleomolTokenAuth)){
            $loginBaleomol = Http::withHeaders([
                'Content-Type' => "application/json",
            ])->post($configs['baleomol_url'] .'/login', [
                'username' => $configs['baleomol_username'],
                'password' => $configs['baleomol_password']
            ]);
            $data = $loginBaleomol['data'] ?? [];
            if(!empty($data['token'])){
                $baleomolTokenAuth = $data['token'];
                Cache::put('baleomol_token_auth', $baleomolTokenAuth);
            }
        }

        $configs['baleomol_token_auth'] = $baleomolTokenAuth;
        config([
            'app' => $configs
        ]);

        return $next($request);
    }
}
