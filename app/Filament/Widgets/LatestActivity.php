<?php
namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\HtmlString;
use Filament\Actions\Action;

class LatestActivity extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Activity::query()->latest()->limit(10))
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime('d M Y h:i A')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('causer.name')
                    ->label('Admin')
                    ->default('System'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Action')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('subject_type')
                    ->label('Resource')
                    ->formatStateUsing(fn ($state) => str($state)->afterLast('\\')->title()),

                // NEW: This identifies the specific item (Post Title, Banner Title, etc.)
                Tables\Columns\TextColumn::make('subject')
                    ->label('Target Item')
                    ->formatStateUsing(function ($record) {
                        if (!$record->subject) return 'Deleted / Manual';
                        
                        // Try to find a name/title. 
                        // Since you use translations, we check for 'title' or 'name'
                        $subject = $record->subject;
                        $label = $subject->title ?? $subject->name ?? 'ID: ' . $subject->id;

                        // If it's a translatable array, get the English version
                        if (is_array($label)) {
                            return $label['en'] ?? array_values($label)[0];
                        }

                        return $label;
                    })

            ])
            ->actions([
                Action::make('view_details')
                    ->label('View Details')
                    ->icon('heroicon-m-eye')
                    ->color('info')
                    ->modalHeading('Activity Property Details')
                    ->modalSubmitAction(false)
                    ->modalContent(function (Activity $record) {
                        $props = $record->properties->toArray();
                        
                        // Wrap in LTR div to prevent the RTL reversal in the screenshot
                        $html = '<div class="space-y-4" dir="ltr" style="text-align: left !important;">';
                        
                        if (isset($props['attributes'])) {
                            $html .= '<div><strong>New Values:</strong><pre class="p-2 mt-1 text-xs bg-gray-100 rounded border dark:bg-gray-800">' . json_encode($props['attributes'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '</pre></div>';
                        }
                        
                        if (isset($props['old'])) {
                            $html .= '<div><strong>Previous Values:</strong><pre class="p-2 mt-1 text-xs bg-gray-50 rounded border dark:bg-gray-900">' . json_encode($props['old'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '</pre></div>';
                        }
                        
                        $html .= '</div>';
                        return new HtmlString($html);
                    })
            ]);
    }
}