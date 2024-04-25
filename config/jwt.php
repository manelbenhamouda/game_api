<?php

return [
    'secret' => env('JWT_SECRET'),
    'ttl' => 60, // Token time to live in minutes
    'refresh_ttl' => 20160, // Time to refresh the token in minutes
    'algo' => 'HS256', // Algorithm used to sign the token
    'required_claims' => ['iss', 'iat', 'nbf', 'sub', 'jti'],
    'blacklist_enabled' => env('JWT_BLACKLIST_ENABLED', true),
    'providers' => [
        'jwt' => Tymon\JWTAuth\Providers\JWT\Lcobucci::class,
        'auth' => Tymon\JWTAuth\Providers\Auth\Illuminate::class,
        'storage' => Tymon\JWTAuth\Providers\Storage\Illuminate::class,
    ],
];
