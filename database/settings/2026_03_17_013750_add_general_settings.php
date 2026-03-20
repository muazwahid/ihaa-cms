<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.default_locale', 'en');
        $this->migrator->add('general.maintenance_mode', false);
        $this->migrator->add('general.site_language', 'dv');
    }
};
