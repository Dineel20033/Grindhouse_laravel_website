<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate; // <-- REQUIRED: Import the Gate facade
use Illuminate\Support\Facades\URL;  // <-- REQUIRED: Import the URL facade
use App\Models\User;                 // <-- REQUIRED: Import the User Model
use Illuminate\Support\ServiceProvider; // Use the base ServiceProvider for AppServiceProvider

class AppServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Force HTTPS in production (Fixes mixed content issues on Railway)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Define the ability/permission required to access the administrative routes
        Gate::define('access-admin', function (User $user) {
            // This checks the 'is_admin' column added in the migration (casted to boolean)
            return $user->is_admin === true; 
        });
        
        // No parent::boot() call is needed because the parent provider does not implement a boot() method.
    }
}