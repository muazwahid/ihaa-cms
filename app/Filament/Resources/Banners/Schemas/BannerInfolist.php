<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BannerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('image_path')->label(__('navigation.form.image_path')),
                TextEntry::make('link_url')->label(__('navigation.form.link_url')),
                IconEntry::make('is_active')->label(__('navigation.form.link_url'))
                    ->boolean(),
                TextEntry::make('sort_order')->label(__('navigation.form.sort_order'))
                    ->numeric(),
                TextEntry::make('created_at')->label(__('navigation.form.created_at'))
                    ->dateTime(),
                TextEntry::make('updated_at')->label(__('navigation.form.updated_at'))
                    ->dateTime(),
            ]);
    }
}
