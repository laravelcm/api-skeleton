<?php

declare(strict_types=1);

namespace Core\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

final class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(
            callback: static fn (object $notifiable, string $token) =>
                config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}"
        );
    }
}
