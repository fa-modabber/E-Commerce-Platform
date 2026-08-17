@php
    $about = App\Models\AboutUs::first();
@endphp

@extends('layout.master')
@section('title', 'Home Page')

@section('content')
    <section class="about-section layout-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ">
                    <div class="img-box">
                        <img src="{{ asset('/images/about-img.png') }}" alt="" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-box">
                        <div class="heading_container">
                            <h2>
                                {{ $about->title }}
                            </h2>
                        </div>
                        <p>
                            {{ $about->body }}
                        </p>
                        <a href="{{ $about->link }}">
                            مشاهده بیشتر
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
