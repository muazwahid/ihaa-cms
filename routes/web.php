<?php

use App\Models\Form; // Make sure to import your Form model
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// The Live Preview Route
Route::get('/forms/preview/{slug}', function ($slug) {
    // 1. Find the form by its slug
    $form = Form::where('slug', $slug)->firstOrFail();
    
    // 2. Return a dedicated preview view
    return view('filament.forms.preview', [
        'form' => $form
    ]);
})->name('forms.preview');