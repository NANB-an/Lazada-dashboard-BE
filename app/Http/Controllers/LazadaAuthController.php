<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\LazadaToken;
class LazadaAuthController extends Controller
{
    public function redirect()
    {
        $clientId = config('services.lazada.client_id');
        $redirectUri = urlencode(config('services.lazada.redirect_uri'));
        $authUrl = "https://auth.lazada.com/oauth/authorize?response_type=code&force_auth=true&client_id={$clientId}&redirect_uri={$redirectUri}";

        return redirect()->away($authUrl);

    }

    public function callback(Request $request)
    {
        $code = $request->query('code');

        if (!$code) {
            return response()->json(['error' => 'No code provided'], 400);
        }

        // 🔥 MOCK response for now, since you’re waiting for Lazada approval:
        $data = [
            'access_token' => 'mock_access_token',
            'refresh_token' => 'mock_refresh_token',
            'expires_in' => 86400, // 1 day
        ];
        //for lazada verified user
        // $response = Http::asForm()->post('https://auth.lazada.com/rest/auth/token/create',[
        //     'code'=> $code,
        //     'client_id' => config('services.lazada.client_id'),
        //     'client_secret' => config('services.lazada.client_secret'),
        //     'redirect_uri' => config('services.lazada.redirect_uri'),
        //     'grant_type' => 'authorization_code',
        // ])

        // $data = $response->json();



        // ✅ Save to DB
        LazadaToken::create([
            'access_token' => $data['access_token'],
            'refresh_token' => $data['refresh_token'],
            'expires_at' => now()->addSeconds($data['expires_in']),
        ]);

        return response()->json(['message' => 'Mock Lazada tokens saved!']);
    }
}
