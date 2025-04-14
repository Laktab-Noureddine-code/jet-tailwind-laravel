<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ensure upload directories exist for both methods
        $this->ensureUploadDirectoriesExist();
    }

    /**
     * Ensure that upload directories exist
     */
    private function ensureUploadDirectoriesExist(): void
    {
        try {
            // Regular storage path
            $storagePath = storage_path('app/public/affectations');
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            // Direct upload path for IIS
            $directUploadPath = public_path('uploads/affectations');
            if (!file_exists($directUploadPath)) {
                mkdir($directUploadPath, 0755, true);
            }
        } catch (\Exception $e) {
            // Log error but don't crash the application
            error_log('Error creating upload directories: ' . $e->getMessage());
        }
    }
}
