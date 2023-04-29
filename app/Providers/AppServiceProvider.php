<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class   AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        // custom direction
        Blade::directive('admin', static function () {
            return "<?php if(auth()->check() && auth()->user()->user_type === 'admin'): ?>";
        });

        Blade::directive('endadmin', static function () {
            return '<?php endif; ?>';
        });
    }
}
