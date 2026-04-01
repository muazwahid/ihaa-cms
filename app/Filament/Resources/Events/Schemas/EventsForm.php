<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Schemas\Components\Utilities\Set;
use Gemini\Laravel\Facades\Gemini;


class EventsForm
{
    public static function configure($schema)
    {
        return $schema->components([

            Grid::make([
                'default' => 1,
                'lg' => 2, // responsive: 2 columns on large screens
            ])
            ->columnSpanFull()
            ->schema([
                // LEFT COLUMN
                Section::make('Event Details')
                    ->schema([
                        TranslatableTabs::make()
                            ->locales(['dv' => 'ދިވެހި', 'en' => 'English'])
                            ->schema([

                                TextInput::make('title')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state)))
                                    ->extraInputAttributes(fn ($component) => [
                                    'style' => str_ends_with($component->getStatePath(), '.dv') 
                                        ? 'font-family: "MVTyper", sans-serif !important; direction: rtl; text-align: right; font-size: 1.25rem !important;' 
                                        : 'direction: ltr; text-align: left;',
                                ])
                                ->extraAttributes(fn ($component) => [
                                    'class' => str_ends_with($component->getStatePath(), '.dv') ? 'dv-title-input' : '',
                                ]),


                                RichEditor::make('description')
                                    ->required()
                                    ->hintAction(
                                        Action::make('translateContent')
                                            ->label('Translate ✨')
                                            ->icon('heroicon-m-sparkles')
                                            ->action(function (string|null $state, Set $set, $component) {
                                                if (blank($state)) return;

                                                $isEnglish = str_ends_with($component->getName(), '.en');
                                                $targetLang = $isEnglish ? 'Dhivehi' : 'English';
                                                
                                                // FIXED: Changed 'content' to 'responsibility' to match field name
                                                $targetField = $isEnglish ? 'description.dv' : 'description.en';

                                                try {
                                                    $result = Gemini::generativeModel(model: 'gemini-3-flash-preview')
                                                        ->generateContent("Translate to {$targetLang}. Return ONLY HTML content. Preserve all formatting:\n\n{$state}");
                                                    
                                                    $set($targetField, trim($result->text()));
                                                } catch (\Exception $e) {}
                                            })
                                            
                                    )
                                ->extraInputAttributes(fn ($component) => [
                                    'style' => str_ends_with($component->getStatePath(), '.dv') 
                                        ? 'font-family: "MVTyper", sans-serif !important; direction: rtl; text-align: right;' 
                                        : 'direction: ltr; text-align: left;',
                                ])
                                // 2. Target the outer wrapper for the RTL layout and your custom CSS class
                                ->extraAttributes(fn ($component) => [
                                    'style' => str_ends_with($component->getStatePath(), '.dv') ? 'direction: rtl;' : 'direction: ltr;',
                                    'class' => str_ends_with($component->getStatePath(), '.dv') ? 'dv-rich-editor' : '',
                                ]),
                                TextInput::make('venue')
                                    ->placeholder('e.g., Council Hall')
                                    ->extraInputAttributes(fn ($component) => [
                                        'style' => str_ends_with($component->getStatePath(), '.dv')
                                            ? 'direction: rtl;'
                                            : '',
                                    ]),
                            ]),
                    ]),

                Section::make('Schedule & Media')
                    ->schema([
                        TextInput::make('slug')
                            ->disabled()
                            ->dehydrated(),

                        Grid::make(2)->schema([
                            DatePicker::make('start_date')->required()->native(false),
                            DatePicker::make('end_date')->native(false),
                        ]),

                        TimePicker::make('event_time')->native(false),

                        FileUpload::make('photo')
                            ->image()
                            ->directory('events')
                            ->live() // Crucial for UI updates
                            ->dehydrated(true)
                            ->hintAction(
                        Action::make('generateAiPhoto')
                            ->label('Generate with AI ✨')
                            ->icon('heroicon-m-sparkles')
                            ->color('success')
                            // 1. Open a modal with a form
                            ->form([
                                \Filament\Forms\Components\Textarea::make('final_prompt')
                                    ->label('Review & Edit Prompt')
                                    ->rows(4)
                                    ->helperText('You can tweak this prompt to get better results.')
                                    ->required(),
                            ])
                            // 2. Pre-fill the modal with the generated prompt
                            ->mountUsing(function ($get, Set $set) {
                                $titleData = $get('title');
                                $title = is_array($titleData) 
                                    ? ($titleData['en'] ?? $titleData['dv'] ?? '') 
                                    : ($titleData ?? '');

                                $generatedPrompt = "Create a professional event poster for: {$title}. Style: Minimalist graphic design, high resolution, cinematic lighting.";
                                
                                $set('final_prompt', $generatedPrompt);
                            })
                            // 3. The action now receives the $data from the modal form
                            ->action(function (array $data, Set $set) {
                                try {
                                    $userPrompt = $data['final_prompt']; // This is the prompt you reviewed/edited
                                    $apiKey = config('gemini.api_key');

                                    $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                                        ->withHeaders(['x-goog-api-key' => $apiKey])
                                        ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-3.1-flash-image-preview:generateContent", [
                                            'contents' => [['parts' => [['text' => $userPrompt]]]],
                                            'generationConfig' => ['response_modalities' => ['IMAGE']]
                                        ]);

                                    if ($response->successful()) {
                                        $base64Image = null;
                                        $responseData = $response->json();
                                        
                                        foreach ($responseData['candidates'][0]['content']['parts'] as $part) {
                                            if (isset($part['inline_data']['data'])) {
                                                $base64Image = $part['inline_data']['data'];
                                                break;
                                            }
                                        }

                                        if ($base64Image) {
                                            $filename = 'events/' . time() . '-' . \Illuminate\Support\Str::random(5) . '.png';
                                            \Illuminate\Support\Facades\Storage::disk('public')->put($filename, base64_decode($base64Image));

                                            $set('photo', $filename);
                                            \Filament\Notifications\Notification::make()->title('Image Generated!')->success()->send();
                                        }
                                    } else {
                                        \Filament\Notifications\Notification::make()
                                            ->title('API Error')
                                            ->body($response->json('error.message') ?? 'Unknown error')
                                            ->danger()
                                            ->send();
                                    }
                                } catch (\Exception $e) {
                                    \Filament\Notifications\Notification::make()->title('System Error')->body($e->getMessage())->danger()->send();
                                }
                            })
                    ),
                        Toggle::make('is_featured')
                            ->label('Highlight Event'),
                    ])
            ])
        ]);
    }
}