<?php

namespace App\Http\Middleware;

use Closure;

use Auth0\SDK\Helpers\JWKFetcher;
use Auth0\SDK\Helpers\Tokens\AsymmetricVerifier;
use Auth0\SDK\Helpers\Tokens\SymmetricVerifier;
use Auth0\SDK\Helpers\Tokens\IdTokenVerifier;

class CheckAccess
{
    public function handle($request, Closure $next)
    {
        /* if (!empty(env('AUTH0_AUDIENCE')) && !empty(env('AUTH0_DOMAIN'))) {
            $verifier = new JWTVerifier([
                'valid_audiences' => [env('AUTH0_AUDIENCE')],
                'authorized_iss' => [env('AUTH0_DOMAIN')],
                'supported_algs' => ['RS256']
            ]);
            $token = $request->bearerToken();
            $decodedToken = $verifier->verifyAndDecode($token);
            if (!$decodedToken) {
                abort(403, 'Access denied');
            }
        } */

        $token_issuer  = 'https://'.env('AUTH0_DOMAIN').'/';
        $signature_verifier = null;

        $jwks_fetcher = new JWKFetcher();
        $jwks = $jwks_fetcher->getKeys($token_issuer.'.well-known/jwks.json');
        $signature_verifier = new AsymmetricVerifier($jwks);

        $token_verifier = new IdTokenVerifier(
            $token_issuer,
            env('AUTH0_AUDIENCE'),
            $signature_verifier
        );

        $token = $request->bearerToken();
        $decoded_token = $token_verifier->verify($token);

        return $next($request);
    }
}