@extends('profile.layout.master')
@section('title', 'Wishlist')

@section('main')
    <div class="col-sm-12 col-lg-9">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>محصول</th>
                        <th>نام</th>
                        <th>قیمت</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($wishlist as $item)
                        <tr>
                            <th>
                                <img class="rounded" src="{{ product_image_url($item->product->primary_image) }}"
                                    width="100" alt="" />
                            </th>
                            <td class="fw-bold">
                                <a href="{{ route('products.show', ['product' => $item->product->slug]) }}">
                                    {{ $item->product->name }}
                                </a>
                            </td>
                            <td>
                                @if ($item->product->is_on_sale)
                                    <div>
                                        <del>{{ number_format($item->product->price) }}</del>
                                        {{ number_format($item->product->sale_price) }}
                                        تومان
                                    </div>
                                    <div class="text-danger">
                                        {{ $item->product->sale_percent }}%
                                        تخفیف
                                    </div>
                                @else
                                    <div>
                                        {{ number_format($item->product->price) }}
                                        تومان
                                    </div>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('profile.wishlist.remove', ['wishlist' => $item->id]) }}"
                                    class="btn btn-primary">
                                    حذف
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
