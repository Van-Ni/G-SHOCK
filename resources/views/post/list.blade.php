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
        <div class="section" id="list-blog-wp">
            <div class="section-head clearfix">
                <h3 class="section-title">
                    <span>Blog</span>
                </h3>
            </div>
            <div class="section-detail">
                <ul class="list-item">
                    @foreach ($posts as $item)
                        <li class="blog-item clearfix">
                            <a href="{{ action('PostController@detail', ['post_slug' => $item->post_slug]) }}"
                                title="" class="thumb fl-left">
                                <img src="{{ asset("$item->thumb") }}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{ action('PostController@detail', ['post_slug' => $item->post_slug]) }}"
                                    title="" class="blog-title title">{{ $item->title }}</a>
                                <span class="create-date">{{ $item->created_at }}</span>
                                <p class="desc">{!! $item->desc !!}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="section" id="paging-wp">
            <div class="section-detail">
                {{ $posts->links() }}
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
                <a href="#" title="" class="thumb">
                    <img src="{{ asset('public/images/banner-1.jpg') }}" alt="">
                </a>
            </div>
        </div>
    </div>
@endsection
