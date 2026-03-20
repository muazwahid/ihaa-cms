<div class="swiper-container my-8 rounded-2xl overflow-hidden shadow-xl" dir="ltr"> 
    <div class="swiper-wrapper">
        @foreach($banners as $banner)
            <div class="swiper-slide relative h-[400px] md:h-[550px]">
                {{-- Use asset() to ensure the subfolder path is included --}}
                <img src="{{ asset('storage/' . $banner->image_path) }}" 
                     class="w-full h-full object-cover" 
                     alt="{{ $banner->getTranslation('title', app()->getLocale()) }}">
                
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent flex items-end pb-12">
                    <div class="container mx-auto px-8">
                        {{-- text-start aligns Left for EN and Right for DV automatically --}}
                        <div class="max-w-2xl text-white text-start">
                            <h2 class="text-3xl md:text-5xl font-bold mb-3 leading-tight">
                                {{ $banner->getTranslation('title', app()->getLocale()) }}
                            </h2>
                            <p class="text-lg text-gray-200 line-clamp-2">
                                {{ $banner->getTranslation('description', app()->getLocale()) }}
                            </p>
                            
                            @if($banner->link_url)
                                <a href="{{ $banner->link_url }}" 
                                   class="inline-block mt-4 px-6 py-2 bg-white text-black font-semibold rounded-lg hover:bg-gray-200 transition">
                                    {{ app()->getLocale() === 'dv' ? 'އިތުރަށް ކިޔުމަށް' : 'Read More' }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="swiper-pagination"></div>
</div>