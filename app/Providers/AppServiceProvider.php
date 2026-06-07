<?php

namespace App\Providers;

use Filament\Auth\Http\Responses\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;
use Livewire\Features\SupportRedirects\Redirector;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LogoutResponseContract::class, function (): object {
            return new class implements LogoutResponseContract
            {
                public function toResponse($request): RedirectResponse | Redirector
                {
                    return redirect()->to('/');
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
