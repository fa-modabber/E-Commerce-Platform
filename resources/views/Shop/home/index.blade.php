@extends('Store.layout.master')

@section('links')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
@endsection

@section('title', 'Home Page')

@section('content')
<section class="hero-section layout-padding">
    <div class="container">
        <div class="row">
            @include('Store.home.slider')
            <div class="col-4">
                <div class="hero-img">
                    <img src="{{ asset('/images/hero.jpg') }}" alt="" />
                </div>
            </div>
        </div>
    </div>
</section>

@include('Store.home.feature')
@include('Store.home.menu')
@include('Store.home.about-us')
@include('Store.home.contact-us')

@endsection

@section('script')
<script>
    var map = L.map("map").setView([35.700105, 51.400394], 14);
    var tiles = L.tileLayer(
        "https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 18,
        }
    ).addTo(map);
    var marker = L.marker([35.700105, 51.400394])
        .addTo(map)
        .bindPopup("<b>webprog</b>")
        .openPopup();
</script>
@endsection
