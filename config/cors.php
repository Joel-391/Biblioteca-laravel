<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Aquí puedes configurar las opciones CORS para que tu frontend React
    | (que corre en Docker en http://localhost:3000) se comunique sin errores
    | con el backend Laravel en http://localhost:8000.
    |
    */

    // Solo aplica CORS a rutas API y auth
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://localhost:3000'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // Necesario si usas cookies de sesión (Sanctum)
];
