@php
    $categories = App\Models\Category::all();
@endphp

<section class="food_section layout_padding-bottom">
    <div class="container" x-data="{ tab: 1 }">
        <div class="heading_container heading_center">
            <h2>
                منو محصولات
            </h2>
        </div>

        <ul class="filters_menu">
            @foreach ($categories as $category)
                <li :class="tab === {{ $loop->iteration }} ? 'active' : ''" @click="tab = {{ $loop->iteration }}">
                    {{ $category->name }}</li>
            @endforeach
        </ul>

        <div class="filters-content">
            @foreach ($categories as $category)
                @php
                    $products = $category->products()->take(3)->get();
                @endphp
                <div x-show="tab === {{ $loop->iteration }}">
                    <div class="row grid">
                        @foreach ($products as $product)
                            @if ($product->is_available)
                                <div class="col-sm-6 col-lg-4">
                                    <div class="box">
                                        <div>
                                            <div class="img-box">
                                                <a href="{{ route('products.show', ['product' => $product->slug]) }}">
                                                    <img class="img-fluid"
                                                        src="{{ product_image_url($product->primary_image) }}"
                                                        alt="">
                                                </a>

                                            </div>
                                            <div class="detail-box">
                                                <a href="{{ route('products.show', ['product' => $product->slug]) }}">
                                                    <h5>
                                                        {{ $product->name }}
                                                    </h5>
                                                </a>
                                                <p>
                                                    {{ $product->description }}
                                                </p>
                                                <div class="options">
                                                    <h6>
                                                        @if ($product->is_on_sale)
                                                            <del>{{ number_format($product->price) }}</del>
                                                            <span>
                                                                <span
                                                                    class="text-danger">({{ $product->sale_percent }}%)</span>
                                                                {{ number_format($product->sale_price) }}
                                                                <span>تومان</span>
                                                            </span>
                                                        @else
                                                            {{ number_format($product->price) }}
                                                            <span>تومان</span>
                                                        @endif
                                                    </h6>
                                                    <div class="d-flex">
                                                        <a class="me-2" href="{{ route('cart.increment', ['product_id' => $product->id]) }}">
                                                            <i class="bi bi-cart-fill text-white fs-6"></i>
                                                        </a>
                                                        <a
                                                            href="{{ route('profile.wishlist.add', ['product_id' => $product->id]) }}">
                                                            <i class="bi bi-heart-fill  text-white fs-6"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="btn-box">
            <a href="">
                مشاهده بیشتر
            </a>
        </div>
    </div>
</section>
