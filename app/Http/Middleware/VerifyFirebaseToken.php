<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\FirebaseService;

class VerifyFirebaseToken
{


   public function handle($request, Closure $next)
        {
            $authHeader = $request->bearerToken();

            if (!$authHeader) {
                return response()->json(['message' => 'Unauthorized: Missing token'], 401);
            }

            $firebase = new FirebaseService();
            $verifiedToken = $firebase->verifyIdToken($authHeader);

            if (!$verifiedToken) {
                return response()->json(['message' => 'Unauthorized: Invalid token'], 401);
            }

            $request->merge(['firebase_user_id' => $verifiedToken->claims()->get('sub')]);

            return $next($request);
        }
}