<!DOCTYPE html>
{{-- Logic to handle RTL for Dhivehi and LTR for English --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      dir="{{ app()->getLocale() === 'dv' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Maarandhoo Council Portal' }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <style>
            /* Quick fix for Dhivehi font if you haven't added one to Tailwind yet */
            [dir="rtl"] {
                font-family: 'MV Waheed', 'Faruma', sans-serif;
            }
        </style>
    </head>
    <body class="bg-gray-50 text-gray-900 antialiased">
        
        <main>
            {{ $slot }}
        </main>

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const swiper = new Swiper('.swiper-container', {
                    loop: true,
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    // Ensures the slider slides in the correct direction for DV
                    rtl: {{ app()->getLocale() === 'dv' ? 'true' : 'false' }},
                });
            });
        </script>
    </body>
</html>