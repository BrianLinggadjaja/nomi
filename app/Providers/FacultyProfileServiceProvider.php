<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FacultyProfileServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Contracts\FacultyProfileContract',
            'App\Services\FacultyProfileService'
        );
    }
}
