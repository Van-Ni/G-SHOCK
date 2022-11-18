@extends('layouts.main')

@section('section')
    @foreach ($page as $item)
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">{{ $item->title }}</a>
                    </li>
                </ul>
            </div>
        </div>
    @endforeach
@endsection
@section('content')
    <div style="background-color: #fff;padding: 20px 15px;" class="main-content fl-right">
        <div class="section" id="detail-blog-wp">
            <div class="section-head clearfix">
                <h3 class="section-title">{{ $item->title }}</h3>
            </div>
            <div class="section-detail">
                <span class="create-date">{{ $item->created_at }}</span>
                <div class="detail">
                    {!! $item->content !!}
                </div>
                
            </div>
        </div>
        <div class="section" id="social-wp">
            <div class="section-detail">
                <div class="fb-like" data-href="" data-layout="button_count" data-action="like" data-size="small"
                    data-show-faces="true" data-share="true"></div>
                <div class="g-plusone-wp">
                    <div class="g-plusone" data-size="medium"></div>
                </div>
                <div class="fb-comments" id="fb-comment" data-href="" data-numposts="5"></div>
            </div>
        </div>
    </div>
@endsection
@section('sidebar')
    <div class="sidebar fl-left">
        {{-- <div class="section" id="category-product-wp">
        <div class="section-head">
            <h3 class="section-title">Danh mục sản phẩm</h3>
        </div>
        <div class="secion-detail">
            <ul class="list-item">
                <li>
                    <a href="?page=category_product" title="">Điện thoại</a>
                    <ul class="sub-menu">
                        <li>
                            <a href="?page=category_product" title="">Iphone</a>
                        </li>
                        <li>
                            <a href="?page=category_product" title="">Samsung</a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="?page=category_product" title="">Iphone X</a>
                                </li>
                                <li>
                                    <a href="?page=category_product" title="">Iphone 8</a>
                                </li>
                                <li>
                                    <a href="?page=category_product" title="">Iphone 8
                                        Plus</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="?page=category_product" title="">Oppo</a>
                        </li>
                        <li>
                            <a href="?page=category_product" title="">Bphone</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="?page=category_product" title="">Máy tính bảng</a>
                </li>
                <li>
                    <a href="?page=category_product" title="">laptop</a>
                </li>
                <li>
                    <a href="?page=category_product" title="">Tai nghe</a>
                </li>
                <li>
                    <a href="?page=category_product" title="">Thời trang</a>
                </li>
                <li>
                    <a href="?page=category_product" title="">Đồ gia dụng</a>
                </li>
                <li>
                    <a href="?page=category_product" title="">Thiết bị văn phòng</a>
                </li>
            </ul>
        </div>
    </div> --}}
        <div class="section" id="selling-wp">
            <div class="section-head">
                <h3 class="section-title">Sản phẩm bán chạy</h3>
            </div>
            <div class="section-detail">
                <ul class="list-item">
                    @if (!$sellingPr->isEmpty())
                        @foreach ($sellingPr as $item)
                            <li class="clearfix">
                                <a href="{{ action('ProductController@detailProduct', ['product' => $item->product_slug, 'id' => $item->id]) }}"
                                    title="" class="thumb fl-left">
                                    <img class="pr-img" src="{{ asset("{$item->product_thumb}") }}" alt="">
                                </a>
                                <a
                                    href="{{ action('ProductController@detailProduct', ['product' => $item->product_slug, 'id' => $item->id]) }}"class="info fl-right">
                                    <p class="product-name">{{ $item->product_name }}</p>
                                    <div class="price">
                                        <span class="new">{{ currency_format($item->price) }}</span>
                                        <span class="old">{{ currency_format($item->old_price) }}</span>
                                    </div>
                                    <p class="buy-now">Xem ngay</p>
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <div class="section" id="banner-wp">
            <div class="section-detail">
                <a style="margin-bottom:25px" href="#" title="" class="thumb d-block">
                    <img src="{{ asset('public/images/banner-1.jpg') }}" alt="">
                </a>             
            </div>
        </div>
    </div>
@endsection
