<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as FilamentLogin; 
use Illuminate\Contracts\Support\Htmlable;
use Filament\Schemas\Components\Component;
use Filament\Actions\Action;

class Login extends FilamentLogin
{
    // Ensure Livewire knows the correct alias
    public static function getLivewireAlias(): string
    {
        return 'filament.pages.auth.login';
    }

    public function getHeading(): string | Htmlable
    {
        return __('filament-panels.pages.auth.login.heading');
    }

    public function getTitle(): string | Htmlable
    {
        return __('filament-panels.pages.auth.login.title');
    }

    protected function getEmailFormComponent(): Component
    {
        return parent::getEmailFormComponent()
            ->label(__('filament-panels.pages.auth.login.form.email.label'));
    }

    protected function getPasswordFormComponent(): Component
    {
        return parent::getPasswordFormComponent()
            ->label(__('filament-panels.pages.auth.login.form.password.label'));
    }
    protected function getRememberFormComponent(): Component
    {
        return parent::getRememberFormComponent()
            ->label(__('filament-panels.pages.auth.login.form.remember.label'));
    }

    protected function getAuthenticateFormAction(): Action
    {
        return parent::getAuthenticateFormAction()
            ->label(__('filament-panels.pages.auth.login.actions.authenticate.label'));
    }
}