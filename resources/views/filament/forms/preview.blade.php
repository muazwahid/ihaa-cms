<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      dir="{{ app()->getLocale() === 'dv' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        [dir="rtl"] {
            font-family: 'MV Waheed', 'Faruma', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 antialiased">

    {{-- Header --}}
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <h1 class="text-lg font-bold">
                {{ config('app.name') }} Portal
            </h1>
        </div>
    </header>

    {{-- Content --}}
    <main class="py-8">
        @yield('content')
    </main>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

</body>
</html>