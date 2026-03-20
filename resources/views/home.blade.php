<x-app-layout>
    {{-- ... your slider code ... --}}

    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mb-4">
            {{ app()->getLocale() === 'dv' ? 'އިނފްރާސްޓްރަކްޗަރ މަޝްރޫޢުތައް' : 'Infrastructure Projects' }}
        </h2>
        
        <div id="map" style="height: 400px;" class="z-0 rounded-xl shadow-lg my-8"></div>
    </div>

    {{-- ... rest of your content ... --}}

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Your Map Logic
            const map = L.map('map').setView([6.7850, 72.9850], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            const locations = @json($projectLocations);
            locations.forEach(project => {
                if (project.lat && project.lng) {
                    L.marker([project.lat, project.lng])
                        .addTo(map)
                        .bindPopup(`<b>${project.name}</b><br>Progress: ${project.progress_percentage}%`);
                }
            });
        });
    </script>
    @endpush
</x-app-layout>