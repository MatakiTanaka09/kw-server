<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */
    'supportsCredentials' => true,
    'allowedOrigins' => ["http://app.kidsweekend.test:3000"],
    'allowedOriginsPatterns' => ['@^chrome-extension://.*@'],
    'allowedHeaders' => ['Origin', 'Content-Type', 'Authorization', 'X-Requested-With'],
    'allowedMethods' => ['GET', 'POST', 'PUT', 'DELETE'],
    'exposedHeaders' => [],
    'maxAge' => 0,
];
