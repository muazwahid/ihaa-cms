<?php
namespace App\Filament\Resources\Categories;

use App\Filament\Resources\Categories\Pages;
use App\Filament\Resources\Categories\Pages\CreateCategory;
use App\Filament\Resources\Categories\Pages\EditCategory;
use App\Filament\Resources\Categories\Pages\ListCategories;
use App\Filament\Resources\Categories\Tables\CategoriesTable;
use App\Filament\Resources\Categories\Schemas\CategoryForm;
use App\Models\Category;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Schemas\Schema; 
use Filament\Tables\Table;
use BackedEnum; 

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
     protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack'; 
    // In v4, ensure this is a simple string or null
    public static function getNavigationGroup(): ?string
    {
        return __('navigation.resources.postBlog'); // Or a hardcoded string like 'Blog'
    }
    public static function getNavigationLabel(): string
    {
        return __('navigation.resources.categories'); 
    }
    // This changes the Heading on the List page
    public static function getPluralModelLabel(): string
    {
        return __('navigation.resources.categories');
    }

    // This changes the "Create Post" button and breadcrumbs
    public static function getModelLabel(): string
    {
        return __('navigation.resources.categories');
    }
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
