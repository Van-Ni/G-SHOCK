@extends('layouts.g-shock')

@section('slider')
    <div id="slider">
        <div class="text-content">
            <div class="text-heading">G-SHOCK VIỆT NAM</div>
            <div class="text-description">Chuyên phân phối đồng hồ Casio chính hãng</div>
        </div>
    </div>
@endsection

@section('home')
    <div class="products-support">
        <div class="overlay">
            <div class="d-flex justify-content-center">
                <div class="products-support-item">
                    <img src="{{ asset('public/img/247.png') }}" alt="" class="products-support-img">
                    <h2 class="products-support-text">Phục vụ 24/7</h2>
                </div>

                <div class="products-support-item">
                    <img src="{{ asset('public/img/free.png') }}" alt="" class="products-support-img">
                    <h2 class="products-support-text">Giao hàng tận nơi</h2>
                </div>

                <div class="products-support-item">
                    <img src="{{ asset('public/img/free1.png') }}" alt="" class="products-support-imgfree">
                    <h2 class="products-support-text">Miễn phí vận chuyển</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Danh mục sản phẩm -->
    <div class="headline">
        <div class="overlay">
            <h3 class="heading1">DANH MỤC SẢN PHẨM</h3>
            <ul class="products">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <style>
                            .swiper-slide-invisible-blank{
                                display: none;
                            }
                        </style>
                        @foreach ($product_cat as $item)
                            <div class="swiper-slide">
                                    <div class="products-item ">
                                        <div class="products-top">
                                            <a href="" class="products-thumb">
                                                <img class="products-thumb-img" src="{{ asset($item->cat_thumb) }}"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="products-info">
                                            <a href="" class="products-cat">{{ $item->cat_name }}<br> </a>
                                            <a href="" class="products-amount">{{ $item->products_count }} SẢN PHẨM</a>
                                        </div>
                                    </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </ul>
        </div>
    </div>
    <!-- Sản phẩm giảm giá -->
    <div class="headline">
        <div class="overlay">
            <h3 class="heading2">SẢN PHẨM BÁN CHẠY</h3>
            <ul class="products">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        @foreach ($sellingPr as $item)
                        <div class="swiper-slide">
                            <li>
                                <div class="products-item">
                                    <div class="products-top">
                                        <a href="" class="products-thumb">
                                            <img class="products-thumb-img" src="{{ asset($item->product_thumb) }}"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="products-info">
                                        <a href="" class="products-cat-discount">{{ $item->product_name }} <br> </a>
                                        <a href="" class="products-amount-cost">{{ currency_format($item->price) }}</a>
                                        <a href="" class="products-amount-discount">{{ currency_format($item->old_price) }}</a>
                                    </div>
                                    <div class="products-btn">
                                        <button class="products-btn-add">THÊM VÀO GIỎ</button>
                                    </div>
                                </div>
                            </li>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </ul>
        </div>
    </div>
    <!-- Sản phẩm nổi bật -->
    <div class="headline">
        <div class="overlay">
            <h3 class="heading3">SẢN PHẨM MỚI NHẤT</h3>
            <ul class="products">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        @foreach ($sellingPr as $item)
                        <div class="swiper-slide">
                            <li>
                                <div class="products-item">
                                    <div class="products-top">
                                        <a href="" class="products-thumb">
                                            <img class="products-thumb-img" src="{{ asset($item->product_thumb) }}"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="products-info">
                                        <a href="" class="products-cat-discount">{{ $item->product_name }} <br> </a>
                                        <a href="" class="products-amount-cost">{{ currency_format($item->price) }}</a>
                                        <a href="" class="products-amount-discount">{{ currency_format($item->old_price) }}</a>
                                    </div>
                                    <div class="products-btn">
                                        <button class="products-btn-add">THÊM VÀO GIỎ</button>
                                    </div>
                                </div>
                            </li>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </ul>
        </div>
    </div>

    {{-- tin tuc --}}
    <div class="headline">
        <div class="overlay">
            <h3 class="heading1">Tin tức sự kiện</h3>
            <ul class="products">
                <div class="swiper mySwiperNew">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <li>
                                <a class="products-item ">
                                    <div class="products-top">
                                        <a href="" class="products-thumb">
                                            <img class="products-thumb-img"
                                                src="http://mauweb.monamedia.net/gwatch/wp-content/uploads/2018/11/banner-02.jpg"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="products-info">
                                        <a href="" class="products-cat">Lorem ipsum dolor sit amet
                                            consectetur.<br> </a>
                                        <a href="" class="products-amount">Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit. Atque, eveniet. Tempora voluptatum facere
                                            delectus itaque!</a>
                                    </div>
                                </a>
                            </li>
                        </div>
                        <div class="swiper-slide">
                            <li>
                                <a class="products-item ">
                                    <div class="products-top">
                                        <a href="" class="products-thumb">
                                            <img class="products-thumb-img"
                                                src="http://mauweb.monamedia.net/gwatch/wp-content/uploads/2018/11/banner-02.jpg"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="products-info">
                                        <a href="" class="products-cat">Lorem ipsum dolor sit amet
                                            consectetur.<br> </a>
                                        <a href="" class="products-amount">Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit. Atque, eveniet. Tempora voluptatum facere
                                            delectus itaque!</a>
                                    </div>
                                </a>
                            </li>
                        </div>
                        <div class="swiper-slide">
                            <li>
                                <a class="products-item ">
                                    <div class="products-top">
                                        <a href="" class="products-thumb">
                                            <img class="products-thumb-img"
                                                src="http://mauweb.monamedia.net/gwatch/wp-content/uploads/2018/11/banner-02.jpg"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="products-info">
                                        <a href="" class="products-cat">Lorem ipsum dolor sit amet
                                            consectetur.<br> </a>
                                        <a href="" class="products-amount">Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit. Atque, eveniet. Tempora voluptatum facere
                                            delectus itaque!</a>
                                    </div>
                                </a>
                            </li>
                        </div>
                        <div class="swiper-slide">
                            <li>
                                <a class="products-item ">
                                    <div class="products-top">
                                        <a href="" class="products-thumb">
                                            <img class="products-thumb-img"
                                                src="http://mauweb.monamedia.net/gwatch/wp-content/uploads/2018/11/banner-02.jpg"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="products-info">
                                        <a href="" class="products-cat">Lorem ipsum dolor sit amet
                                            consectetur.<br> </a>
                                        <a href="" class="products-amount">Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit. Atque, eveniet. Tempora voluptatum facere
                                            delectus itaque!</a>
                                    </div>
                                </a>
                            </li>
                        </div>
                        <div class="swiper-slide">
                            <li>
                                <a class="products-item ">
                                    <div class="products-top">
                                        <a href="" class="products-thumb">
                                            <img class="products-thumb-img"
                                                src="http://mauweb.monamedia.net/gwatch/wp-content/uploads/2018/11/banner-02.jpg"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="products-info">
                                        <a href="" class="products-cat">Lorem ipsum dolor sit amet
                                            consectetur.<br> </a>
                                        <a href="" class="products-amount">Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit. Atque, eveniet. Tempora voluptatum facere
                                            delectus itaque!</a>
                                    </div>
                                </a>
                            </li>
                        </div>
                        <div class="swiper-slide">
                            <li>
                                <a class="products-item ">
                                    <div class="products-top">
                                        <a href="" class="products-thumb">
                                            <img class="products-thumb-img"
                                                src="http://mauweb.monamedia.net/gwatch/wp-content/uploads/2018/11/banner-02.jpg"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="products-info">
                                        <a href="" class="products-cat">Lorem ipsum dolor sit amet
                                            consectetur.<br> </a>
                                        <a href="" class="products-amount">Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit. Atque, eveniet. Tempora voluptatum facere
                                            delectus itaque!</a>
                                    </div>
                                </a>
                            </li>
                        </div>



                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </ul>
        </div>
    </div>

    {{-- banner --}}
    <div class="box-image d-flex">
        <div class="box-zoom1">
            <img src="http://mauweb.monamedia.net/mirora/wp-content/uploads/2018/12/img1-bottom-mirora1.jpg"
                alt="" width="1000px" height="250px">
        </div>
        <div class="box-zoom2">
            <img src="http://mauweb.monamedia.net/mirora/wp-content/uploads/2018/12/img2-bottom-mirora1.jpg"
                alt="" width="1000px" height="250px">
        </div>
    </div>
@endsection
