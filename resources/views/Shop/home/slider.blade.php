@php
     $sliders = App\Models\Slider::all();
 @endphp

 <div class="col-8">
     <div id="customCarousel1" class="carousel slide custom-slider" data-bs-ride="carousel" style="border: 2px solid black">
         <ol class="carousel-indicators">
            @foreach ($sliders as $slider)
             <li data-bs-target="#customCarousel1" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>

             @endforeach
         </ol>
         <div class="carousel-inner">
             @foreach ($sliders as $slider)
                 <div class="carousel-item {{ $loop->first ? 'active' : '' }} ">
                     <div class="slider-content">
                         <h2 class="mb-3 fw-bold">{{ $slider->title }}</h2>
                         <p>
                             {{ $slider->body }}
                         </p>
                         <div class="btn-box">
                             <a href="{{ $slider->link_address }}" class="btn" role="button"> {{ $slider->link_title }} </a>
                         </div>
                     </div>
                 </div>
             @endforeach
         </div>
     </div>

 </div>
