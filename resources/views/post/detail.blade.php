@extends('layouts.main')
@section('section')
    <div class="secion" id="breadcrumb-wp">
        <div class="secion-detail">
            <ul class="list-item clearfix">
                <li>
                    <a href="" title="">Trang chủ</a>
                </li>
                <li>
                    <a href="" title="">Blog</a>
                </li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
    <div class="main-content fl-right">
        @foreach ($post as $item)
            <div class="section" id="detail-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">{{ $item->title }}</h3>
                </div>
                <div class="section-detail">
                    <span class="create-date">{{ $item->created_at }}</span>
                    <div class="detail">
                        {!! $item->desc !!}
                    </div>
                    <div class="content">
                        {!! $item->content !!}
                    </div>
                </div>
            </div>
        @endforeach
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
                <a href="#" title="" class="thumb">
                    <img src="{{ asset('public/images/banner-3.png') }}" alt="">
                </a>
            </div>
        </div>
    </div>
@endsection
