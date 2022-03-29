<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*',
        'sub.domain.zone' => [
            'prefix/*'
<<<<<<< HEAD
        ],
=======
        ]
>>>>>>> 86174792523889bc51d0dd98860dc0eb34db59a0
    ];
}
