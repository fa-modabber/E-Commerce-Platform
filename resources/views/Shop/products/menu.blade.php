@extends('layout.master')
@section('title', 'Menu')

@section('script')


    <script type="text/javascript">
        document.addEventListener('alpine:init', () => {
            Alpine.data('filter', () => ({
                search: '',
                currentUrl: '{{ url()->current() }}',
                params: new URLSearchParams(location.search),

                filter(type, value) {
                    this.params.set(type, value);
                    this.params.delete('page');
                    document.location.href = this.currentUrl + '?' + this.params.toString();
                },
                removeFilter($type) {
                    this.params.delete($type);
                    document.location.href = this.currentUrl + '?' + this.params.toString();
                },
                toggle(type, isChecked) {
                    if (isChecked) {
                        this.params.set(type, 1);
                    } else {
                        this.params.delete(type);
                    }
                    this.params.delete('page');
                    document.location.href = this.currentUrl + '?' + this.params.toString();
                }
            }))
        });
    </script>
@endsection

@section('content')
    <section class="food_section layout_padding">
        <div class="container">
            <div class="row">
                <div x-data="filter" class="col-sm-12 col-lg-3">
                    <div>
                        <label class="form-label">جستجو
                            @if (request()->has('search'))
                                <i @click="removeFilter('search')" class="bi bi-x text-danger fs-5 cursor-pointer"></i>
                            @endif
                        </label>
                        <div class="input-group mb-3">
                            <input type="text" x-model="search" class="form-control" placeholder="نام محصول ..." />
                            <button @click="filter('search',search)" class="input-group-text">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <hr />
                    <div class="filter-list">
                        <div class="form-label">
                            دسته بندی
                            @if (request()->has('category'))
                                <i @click="removeFilter('category')" class="bi bi-x text-danger fs-5 cursor-pointer"></i>
                            @endif
                        </div>
                        <ul>
                            @foreach ($categories as $category)
                                <li @click="filter('category', '{{ $category->id }}')"
                                    class="my-2 cursor-pointer 
                                    {{ request()->has('category') && request()->category == $category->id ? 'filter-list-active' : '' }}
                                    ">
                                    {{ $category->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <hr />
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="toggle">فقط کالاهای موجود</label>
                        <input @change="toggle('is_available', $event.target.checked)"
                            {{ request()->has('is_available') && request('is_available') == 1 ? 'checked' : '' }}
                            class="form-check-input" type="checkbox" role="switch" id="toggle">
                    </div>
                    <hr />
                    <div>
                        <label class="form-label">مرتب سازی
                            @if (request()->has('sort'))
                                <i @click="removeFilter('sort')" class="bi bi-x text-danger fs-5 cursor-pointer"></i>
                            @endif
                        </label>
                        <div class="form-check my-2">
                            <input @change="filter('sort','max')" class="form-check-input" type="radio"
                                {{ request()->has('sort') && request('sort') == 'max' ? 'checked' : '' }}
                                name="flexRadioDefault" />
                            <label class="form-check-label cursor-pointer">
                                بیشترین قیمت
                            </label>
                        </div>
                        <div class="form-check my-2">
                            <input @change="filter('sort','min')"
                                {{ request()->has('sort') && request('sort') == 'min' ? 'checked' : '' }}
                                class="form-check-input" type="radio" name="flexRadioDefault" />
                            <label class="form-check-label cursor-pointer">
                                کمترین قیمت
                            </label>
                        </div>
                        <div class="form-check my-2">
                            <input @change="filter('sort','bestseller')"
                                {{ request()->has('sort') && request('sort') == 'bestseller' ? 'checked' : '' }}
                                class="form-check-input" type="radio" name="flexRadioDefault" />
                            <label class="form-check-label cursor-pointer">
                                پرفروش ترین
                            </label>
                        </div>
                        <div class="form-check my-2">
                            <input @change="filter('sort','on_sale')"
                                {{ request()->has('sort') && request('sort') == 'on_sale' ? 'checked' : '' }}
                                class="form-check-input" type="radio" name="flexRadioDefault" />
                            <label class="form-check-label cursor-pointer">
                                با تخفیف
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-9">
                    @if (request()->has('search'))
                        <h5>مشاهده نتایج جستجو برای «{{ request()->get('search') }}»</h5>
                    @endif
                    @if ($products->isEmpty())
                        <div class="text-center">
                            <h5>محصولی یافت نشد!</h5>
                        </div>
                    @endif

                    <div class="row gx-3">
                        @foreach ($products as $product)
                            <div class="col-sm-6 col-lg-4">
                                <div class="box">
                                    <div>
                                        <div class="img-box">
                                            <a href="{{ route('products.show', ['product' => $product->slug]) }}">
                                                <img class="img-fluid"
                                                    src="{{ product_image_url($product->primary_image) }}" alt="">
                                            </a>

                                        </div>
                                        <div class="detail-box">
                                            <h5>
                                                <a href="{{ route('products.show', ['product' => $product->slug]) }}">
                                                    {{ $product->name }}
                                                </a>
                                            </h5>

                                            <div class="options">
                                                @if ($product->is_available)
                                                    @if ($product->is_on_sale)
                                                        <h6>
                                                            <del>{{ number_format($product->price) }}</del>
                                                            <span>
                                                                <span
                                                                    class="text-danger">({{ $product->sale_percent }}%)</span>
                                                                {{ number_format($product->sale_price) }}
                                                                <span>تومان</span>
                                                            </span>
                                                        </h6>
                                                    @else
                                                        <h6>
                                                            {{ number_format($product->price) }}
                                                            <span>تومان</span>
                                                        </h6>
                                                    @endif
                                                    <div class="d-flex">
                                                        <a class="me-2"
                                                            href="{{ route('cart.increment', ['product_id' => $product->id]) }}">
                                                            <i class="bi bi-cart-fill text-white fs-6"></i>
                                                        </a>
                                                        <a
                                                            href="{{ route('profile.wishlist.add', ['product_id' => $product->id]) }}">
                                                            <i class="bi bi-heart-fill text-white fs-6"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <h6 class="text-danger">ناموجود</h6>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $products->withQueryString()->links('layout.paginate') }}
                </div>
            </div>
        </div>
    </section>
@endsection
