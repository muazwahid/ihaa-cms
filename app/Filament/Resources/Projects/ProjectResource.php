<?php

namespace App\Filament\Resources\Projects;

use App\Models\Project;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use App\Filament\Resources\Projects\Pages;
use BackedEnum;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cube';

    public static function getNavigationLabel(): string
    {
        return __('navigation.resources.projects'); 
    }
    // This changes the Heading on the List page
    public static function getPluralModelLabel(): string
    {
        return __('navigation.resources.projects');
    }

    // This changes the "Create Post" button and breadcrumbs
    public static function getModelLabel(): string
    {
        return __('navigation.resources.projects');
    }
    public static function form(Schema $schema): Schema
    {
        // Make sure this namespace matches your folder structure exactly
        return \App\Filament\Resources\Projects\Schemas\ProjectForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        // Make sure this namespace matches your folder structure exactly
        return \App\Filament\Resources\Projects\Tables\ProjectsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'view' => Pages\ViewProject::route('/{record}'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}