<?php

namespace App\Filament\Resources\Downloads;

use App\Models\Download; // Fixed: Use the singular model
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use BackedEnum;
use App\Filament\Resources\Downloads\Pages\CreateDownload;
use App\Filament\Resources\Downloads\Pages\EditDownload;
use App\Filament\Resources\Downloads\Pages\ListDownloads;
use App\Filament\Resources\Downloads\Schemas\DownloadForm; // Make sure this file exists
use App\Filament\Resources\Downloads\Tables\DownloadsTable; // Make sure this file exists

class DownloadResource extends Resource
{
    protected static ?string $model = Download::class;
    
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-down-tray';

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.resources.postBlog'); 
    }
    public static function getNavigationLabel(): string
    {
        return __('navigation.resources.downloads');
    }

    public static function getPluralModelLabel(): string
    {
        return __('navigation.resources.downloads');
    }

    public static function getModelLabel(): string
    {
        return __('navigation.resources.download');
    }

    public static function form(Schema $schema): Schema
    {
        // This tells Filament to use your PostForm class
        return DownloadForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DownloadsTable::configure($table);
            
    }
        public static function getPages(): array
    {
        return [
            'index' => ListDownloads::route('/'),
            'create' => CreateDownload::route('/create'),
            'edit' => EditDownload::route('/{record}/edit'),
        ];
    }
}