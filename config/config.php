<?php

return [
    // routes configurations
    'builder_prefix' => 'hello', // prefix for builder

    'middleware' => null, // middleware for builder

    'frontend_prefix' => 'hi', // prefix for frontend

    // dynamic traits model for set dynamic content, define your dynamic models
    'dynamic_traits_model' => [
        'users' => \App\Models\User::class,
    ],
];
