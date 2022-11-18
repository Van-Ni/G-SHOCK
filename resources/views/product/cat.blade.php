@extends('layouts.main')
@section('section')
    <div class="secion" id="breadcrumb-wp">
        <div class="secion-detail">
            <ul class="list-item clearfix">
                <li>
                    <a href="" title="">Trang chủ</a>
                </li>
                <li>
                    @foreach ($cat_name as $item)
                        <a href="{{ action('ProductController@cat', ['parent_cat' => $item->slug]) }}"
                            title="">{{ $item->cat_name }}</a>
                    @endforeach
                </li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
    <div class="main-content fl-right">
        <div class="section" id="list-product-wp">
            <div class="position-relative section-head clearfix">
                <div class="position-absolute filter-wp">
                    <p class="desc">Xem tất cả {{ count($products) }} sản phẩm</p>
                    <div class="form-filter">
                        <form method="GET" action="">
                            <select name="arrange">
                                <option value="0">Sắp xếp</option>
                                <option value="1">Từ A-Z</option>
                                <option value="2">Từ Z-A</option>
                                <option value="3">Giá cao xuống thấp</option>
                                <option value="4">Giá thấp lên cao</option>
                            </select>
                            <button type="submit">Lọc</button>
                        </form>
                    </div>
                </div>
                <h3 style="width: 100%;" class="section-title fl-left">
                    @foreach ($cat_name as $item)
                        <span>{{ $item->cat_name }}</span>
                    @endforeach
                </h3>
                {{-- <div class="filter-wp fl-right">
                    <p class="desc">Hiển thị 45 trên 50 sản phẩm</p>
                    <div class="form-filter">
                        <form method="POST" action="">
                            <select name="select">
                                <option value="0">Sắp xếp</option>
                                <option value="1">Từ A-Z</option>
                                <option value="2">Từ Z-A</option>
                                <option value="3">Giá cao xuống thấp</option>
                                <option value="3">Giá thấp lên cao</option>
                            </select>
                            <button type="submit">Lọc</button>
                        </form>
                    </div>
                </div> --}}
            </div>
            <div class="section-detail">
                <ul class="list-item clearfix">
                    @if (!$products->isEmpty())
                        @foreach ($products as $item)
                            <li class="position-relative">
                                <a href="{{ action('ProductController@detailProduct', ['product' => $item->product_slug, 'id' => $item->id]) }}"
                                    title="" class="thumb">
                                    <img class="pr-img" src="{{ asset("$item->product_thumb") }}">
                                    <p href="{{ action('ProductController@detailProduct', ['product' => $item->product_slug, 'id' => $item->id]) }}"
                                        title="" class="product-name">{{ $item->product_name }}</p>
                                    <div class="price">
                                        <span class="new">{{ currency_format($item->price) }}</span>
                                        <span class="old">{{ currency_format($item->old_price) }}</span>
                                    </div>
                                    <p class="position-absolute add-cart detail-cart hover-filled-slide-left">
                                        <span><i class="fa-solid fa-eye"></i> Xem chi tiết</span>
                                    </p>
                                </a>
                            </li>
                        @endforeach
                    @else
                        <div class="container-empty">
                            <img src="{{ asset('public/images/empty_box.png') }}" alt="">
                            <h4>Không tìm thấy kết quả nào</h4>
                            <p>Háy thay đổi bộ lọc tìm kiếm</p>
                        </div>
                    @endif
                </ul>
            </div>
        </div>
        <div class="section" id="paging-wp">
            <div class="section-detail">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
@section('sidebar')
    <div class="sidebar fl-left">
        <div class="section" id="category-product-wp">
            <div class="section-head">
                <h3 class="section-title">Danh mục sản phẩm</h3>
            </div>
            <div class="secion-detail">
                @php
                    data_tree_cat($tree_product_cats);
                @endphp
            </div>
        </div>
        <div class="section" id="filter-product-wp">
            <div class="section-head">
                <h3 class="section-title">Bộ lọc</h3>
            </div>
            <div class="section-detail">
                <form method="GET" action="#">
                    <table>
                        <thead>
                            <tr>
                                <td colspan="2">Giá</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="radio" value="1" name="r_price"></td>
                                <td>Dưới 500.000đ</td>
                            </tr>
                            <tr>
                                <td><input type="radio" value="2" name="r_price"></td>
                                <td>500.000đ - 1.000.000đ</td>
                            </tr>
                            <tr>
                                <td><input type="radio" value="3" name="r_price"></td>
                                <td>1.000.000đ - 5.000.000đ</td>
                            </tr>
                            <tr>
                                <td><input type="radio" value="4" name="r_price"></td>
                                <td>5.000.000đ - 10.000.000đ</td>
                            </tr>
                            <tr>
                                <td><input type="radio" value="5" name="r_price"></td>
                                <td>Trên 10.000.000đ</td>
                            </tr>
                        </tbody>
                    </table>
                    <table>
                        <thead>
                            <tr>
                                <td colspan="2">Hãng</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$trademarks->isEmpty())
                                @foreach ($trademarks as $item)
                                    <tr>
                                        <td><input type="checkbox" value="{{ $item->id }}" name="r_brand[]"></td>
                                        <td>{{ $item->trademark_name }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <button type="submit" class="btn-filter"value="Lọc">
                        <i class="fa-solid fa-filter"></i>Lọc</button>
                </form>
            </div>
        </div>
        <div class="section" id="banner-wp">
            <div class="section-detail">
                <a href="#" title="" class="thumb">
                    <img src="{{ asset('public/images/banner-1.jpg') }}" alt="">
                </a>
            </div>
        </div>
    </div>
@endsection
