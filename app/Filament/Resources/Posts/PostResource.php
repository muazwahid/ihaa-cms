<?php

namespace App\Filament\Resources\Posts;

use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\EditPost;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Filament\Resources\Posts\Schemas\PostForm; // Make sure this file exists
use App\Filament\Resources\Posts\Tables\PostsTable; // Make sure this file exists
use App\Models\Post;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    // Matching the BannerResource style
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    
    // This changes the Sidebar Label
    public static function getNavigationGroup(): ?string
    {
        return __('navigation.resources.postBlog'); 
    }
    public static function getGroupIcon(): ?string
    {
        // This is the icon for the navigation group
        return 'heroicon-o-arrow-down-tray';
    }
    public static function getNavigationLabel(): string
    {
        return __('navigation.resources.posts');
    }

    // This changes the Heading on the List page
    public static function getPluralModelLabel(): string
    {
        return __('navigation.resources.posts');
    }

    // This changes the "Create Post" button and breadcrumbs
    public static function getModelLabel(): string
    {
        return __('navigation.resources.post');
    }
    public static function getCreateActionLabel(): string
    {
        return __('navigation.new') . ' ' . __('navigation.resources.post');
    }
    public static function form(Schema $schema): Schema
    {
        // This tells Filament to use your PostForm class
        return PostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        // This tells Filament to use your PostsTable class
        return PostsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}