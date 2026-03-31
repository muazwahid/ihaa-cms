<x-filament-widgets::widget>
    <x-filament::section>
        {{-- "flex-row-reverse" pushes the first item (text) to the left and the second item (logo) to the right --}}
        <div class="flex flex-row-reverse items-center justify-between gap-x-4">
            
            {{-- 1. Logo on the Right --}}
            <div class="flex-shrink-0">
                <img src="{{ asset('images/logo.png') }}" class="branding h-20 w-auto" alt="Ihaa Logo">
            </div>

            {{-- 2. Text on the Left --}}
            <div class="flex-1 text-right">
                <h2 class="text-xl font-bold text-gray-950 dark:text-white" style="font-family: 'Aammu', sans-serif;">
                    {{ app()->getLocale() === 'dv' ? 'އިހާ ސީއެމްއެސް v1.0' : 'Ihaa CMS v1.0' }}
                </h2>
                
                <p class="text-sm text-gray-500 mt-1" style="font-family: 'MVTyper', sans-serif;">
                    {{ app()->getLocale() === 'dv' ? 'މިއީ މަޝްރޫއުތައް ބެލެހެއްޓުމަށް ތައްޔާރުކޮށްފައިވާ ސިސްޓަމެކެވެ.' : 'A specialized system for managing council projects and services.' }}
                </p>

                <div class="mt-4 flex justify-end">
                    <x-filament::link 
                        href="https://atoztechmaldives.com" 
                        target="_blank"
                        color="primary"
                        icon="heroicon-m-globe-alt"
                        style="font-family: 'MVTyper', sans-serif;"
                    >
                        {{ app()->getLocale() === 'dv' ? 'އެހީތެރިކަން' : 'Support' }}
                    </x-filament::link>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>