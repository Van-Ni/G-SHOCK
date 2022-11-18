@extends('layouts.g-shock')

@section('content')
    <style>
        #wrapper {
            max-width: 1170px;
            margin: 0 auto;

        }

        /* Product details */
        .products-details {
            margin-top: 70px;
            display: flex;
        }

        .products-thumb {
            padding: 20px 20px;
        }

        .products-thumb-slider {
            width: 600px;
            padding: 20px;
        }

        .products-thumb-img {
            /* width: 600px;
        height: 600px; */
        }


        .products-thumb-key {
            position: relative;
            z-index: 1;
        }

        .product-thumb-item {}

        .products-thumb-nav {
            display: flex;
        }

        .product-thumb-nav-item {
            text-align: center;
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid rgb(155, 154, 154);
            cursor: pointer;
            margin: 20px 10px;
        }

        .product-thumb-nav-item--active {
            border: 2px solid #ebebeb;
        }

        .product-thumb-nav-item:hover {
            background-color: #ccc;
        }

        .products-thumb-nav-img {
            width: 100%;
            height: 100%;

        }

        .products-detail {
            padding: 20px 20px;
        }

        .products-title {
            display: block;
            text-decoration: none;
            font-size: 14px;
            color: #222;
            margin-bottom: 10px;
        }

        .products-heading {
            font-size: 28px;
            color: #555;
            font-weight: 900;
            margin-bottom: 14px;
        }

        .products-price-cost {
            font-size: 24px;
            color: #111;
            text-decoration: line-through;
            font-weight: normal;
            opacity: 0.6;
            margin-right: 10px;
        }

        .products-price-reduced {
            font-size: 24px;
            color: #111;
            font-weight: bold;
        }

        .products-description {
            padding: 16px 0 10px;
        }

        .product-sets {
            font-size: 26px;
            color: #555;
            font-weight: bold;
        }

        .products-infocomes {
            margin-top: 15px;
        }

        .products-infocomes-text {
            font-size: 16px;
            color: #777;
            margin-left: 17px;
            margin-bottom: 10px;
        }

        .products-infocomes-text::marker {
            unicode-bidi: isolate;
            font-variant-numeric: tabular-nums;
            text-transform: none;
            text-indent: 0px !important;
            text-align: start !important;
            text-align-last: start !important;
        }

        .products-form-cart {
            display: flex;
            margin-bottom: 22px;
        }

        .quantity-button-added {}

        .is-form {
            width: 25px;
            height: 40px;
            /* background-color: #f9f9f9; */
            padding: 0 8px;
            border: 1px solid #ddd;
        }

        .input-qty {
            width: 40px;
            height: 40px;
            margin: 0;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #dddddd;
        }

        .is-form {
            width: 25px;
            height: 40px;
            border: 1px solid #ddd;
        }

        .button-add-to-cart {
            font-size: 16px;
            margin: 0 16px;
            padding: 0 20px;
            font-weight: 900;
            color: white;
            background-color: #f03545;
            border: none;
            cursor: pointer;
        }

        .button-add-to-cart:hover {
            background-color: #ca414c;
        }

        .products-pay {
            display: flex;
            justify-content: space-between;
        }

        .pay-ship-automatic {
            display: block;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;

        }

        .products-pay-ship-automatic {
            padding: 0 5px 17px;
        }

        .pay-ship-img {
            width: 91px;
            height: 40px;
            display: flex;

        }

        .products-affilicate {
            padding: 0 10px 20px;
        }

        .affilicate-text {
            font-size: 16px;
            color: #777;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn-affilicate {
            font-size: 16px;
            color: white;
            background-color: #555;
            margin: 0 15px 15px 0;
            padding: 7px 19px;
            border: none;
            cursor: pointer;
        }

        .post-in {
            display: block;
            font-size: 15px;
            padding: 5px 5px;
            border-top: 1px solid #ccc;
        }

        /* Product details */

        /* Products footer */
        .products-content {}

        .products-content-tab {}

        .products-describe {
            font-size: 16px;
            font-weight: 900;
            padding: 10px 15px;
            border: 1px solid #ccc;
        }

        .products-content-tab-panels {
            border: 1px solid #ccc;
            padding: 30px;
            margin-top: 12px;
            margin-bottom: 20px;
        }

        .content-heading {
            font-size: 27px;
            font-weight: 900;
            margin-bottom: 18px;
        }

        .content-text {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .content-prameter {
            font-size: 20px;
            font-weight: 900;
            margin-bottom: 10px;
        }

        .content-prameter-list {
            margin-bottom: 21px;
        }

        .content-prameter-item {
            font-size: 16px;
            margin: 0 0 11px 21px;
        }

        .content-size {
            font-size: 20px;
            font-weight: 900;
            margin-bottom: 10px;
        }

        .content-size-item {
            font-size: 16px;
            margin: 0 0 11px 21px;
        }

        /* Products footer */

        /*similar product  */
        .products-similar {
            position: relative;
            border-top: 1px solid #ccc;
        }

        .product-similar-sale-off {
            position: absolute;
            display: flex;
            align-items: center;
            width: 55px;
            height: 55px;
            background-color: #f03545;
            top: 130px;
            left: 0;
        }

        .product-similar-item-sale-off {
            font-size: 20px;
            margin: auto;
            color: #fff;
            font-weight: 900;
        }




        .products-similar-heading {
            font-size: 20px;
            font-weight: 900;
            margin: 20px 0;
            padding: 15px 0;
        }

        .products-similar-list {
            display: flex;
            list-style: none;
            margin-bottom: 20px;
            border: 1px solid #ccc;

        }

        .products-item {}

        .products-top {}

        .products-thumb-img {
            width: 300px;
            height: 300px;
            margin-bottom: 4px;
            transition: all 0.3s ease-in-out;
        }



        .products-info {
            text-align: center;
            line-height: 1.3;
            margin: 0 8px;
            padding: 15px 0;
            transition: all 0.3s ease-in-out;

        }

        .products-cat {
            text-decoration: none;
            color: rgb(246, 238, 238);
            font-weight: 700;
            font-size: 15px;
        }

        .products-amount {
            text-decoration: none;
            color: rgb(11, 11, 11);
            font-weight: lighter;
            font-size: 10px;
            text-transform: uppercase;
        }


        .products-cat-discount {
            text-decoration: none;
            color: rgb(8, 8, 8);
            font-size: 15px;
        }

        .products-amount-discount {
            text-decoration: none;
            color: rgb(11, 11, 11);
            font-weight: lighter;
            font-size: 20px;
            font-weight: 900;
        }

        .products-amount-cost {
            font-size: 17px;
            text-decoration: none;
            color: rgb(7, 7, 7);
            text-decoration-line: line-through;
        }

        .products-btn {
            text-align: center;
            margin-top: 5px;
        }

        .products-btn-add {
            padding: 10px;
            font-weight: 800;
            margin-bottom: 6px;
            background-color: rgb(123, 122, 123);
            color: #fff;
            border: none;
        }

        .products-btn-add:hover {
            background-color: rgb(58, 57, 57);
        }

        /*similar product  */
    </style>
    <div id="wrapper">
        <!-- Products Details -->
        <div class="products-details">
            <div class="products-thumb-slider">
                <div class="products-thumb-key">
                    <div class="product-thumb-item">
                        <img src="{{ asset($product->product_thumb) }}" alt="products-thumb-slider" class="products-thumb-imgg">
                    </div>
                </div>

                <div class="products-thumb-nav">
                    @foreach ($product_imgs as $item)
                    <div class="product-thumb-nav-item  product-thumb-nav-item--active" onclick="changeImage(this)">
                        <img src="{{ asset($item->thumb_name) }}" alt="products-thumb-nav" class="products-thumb-nav-img">
                    </div>
                    @endforeach
                </div>
            </div>



            <div class="products-detail">
                <H1 class="products-heading">{{ $product->product_name }}</H1>
                <span class="products-price-cost">{{ currency_format($product->price) }}</span>
                <span class="products-price-reduced">{{ currency_format($product->old_price) }}</span>

                <div class="products-description">
                    <ul class="products-infocomes">
                        {!! $product->detail !!}
                    </ul>
                </div>



                <div class="products-form-cart">
                    <div class="buttons_added">
                        <input class="minus is-form" type="button" value="-">
                        <input aria-label="quantity" class="input-qty" max="999" min="1" name=""
                            type="text" value="1">
                        <input class="plus is-form" type="button" value="+">
                    </div>
                    <button class="button-add-to-cart">THÊM VÀO GIỎ</button>
                </div>
                
            </div>
        </div>
        <!-- Products Details -->

        <!-- Products footer -->
        <div class="products-content">
            <span href="" class="products-describe">MÔ TẢ</span>
            <div class="products-content-tab-panels">
                {!! $product->desc !!}
            </div>

            <div class="products-similar">
                <h1 class="products-similar-heading"> SẢN PHẨM TƯƠNG TỰ</h1>
                <ul class="products-similar-list">
                    <li>
                        <div class="products-item">
                            <div class="products-top">
                                <a href="" class="products-thumb">
                                    <img class="products-thumb-img" src="./public/img/giamgia01.png" alt="">
                                </a>
                            </div>
                            <div class="products-info">
                                <a href="" class="products-cat-discount">GWG-1000-1A3DR <br> </a>
                                <a href="" class="products-amount-cost">21,597,000</a>
                                <a href="" class="products-amount-discount">14,999,000đ</a>
                            </div>
                            <div class="products-btn">
                                <button class="products-btn-add">THÊM VÀO GIỎ</button>
                            </div>
                        </div>
                        <div class="product-similar-sale-off">
                            <span class="product-similar-item-sale-off">-22%</span>
                        </div>

                    </li>
                    <li>
                        <div class="products-item">
                            <div class="products-top">
                                <a href="" class="products-thumb">
                                    <img class="products-thumb-img" src="./public/img/giamgia01.png" alt="">
                                </a>
                            </div>
                            <div class="products-info">
                                <a href="" class="products-cat-discount">GWG-1000-1A3DR <br> </a>
                                <a href="" class="products-amount-cost">21,597,000</a>
                                <a href="" class="products-amount-discount">14,999,000đ</a>
                            </div>
                            <div class="products-btn">
                                <button class="products-btn-add">THÊM VÀO GIỎ</button>
                            </div>
                        </div>
                        <div class="product-similar-sale-off">
                            <span class="product-similar-item-sale-off">-22%</span>
                        </div>

                    </li>
                    <li>
                        <div class="products-item">
                            <div class="products-top">
                                <a href="" class="products-thumb">
                                    <img class="products-thumb-img" src="./public/img/giamgia01.png" alt="">
                                </a>
                            </div>
                            <div class="products-info">
                                <a href="" class="products-cat-discount">GWG-1000-1A3DR <br> </a>
                                <a href="" class="products-amount-cost">21,597,000</a>
                                <a href="" class="products-amount-discount">14,999,000đ</a>
                            </div>
                            <div class="products-btn">
                                <button class="products-btn-add">THÊM VÀO GIỎ</button>
                            </div>
                        </div>
                        <div class="product-similar-sale-off">
                            <span class="product-similar-item-sale-off">-22%</span>
                        </div>

                    </li>
                    <li>
                        <div class="products-item">
                            <div class="products-top">
                                <a href="" class="products-thumb">
                                    <img class="products-thumb-img" src="./public/img/giamgia01.png" alt="">
                                </a>
                            </div>
                            <div class="products-info">
                                <a href="" class="products-cat-discount">GWG-1000-1A3DR <br> </a>
                                <a href="" class="products-amount-cost">21,597,000</a>
                                <a href="" class="products-amount-discount">14,999,000đ</a>
                            </div>
                            <div class="products-btn">
                                <button class="products-btn-add">THÊM VÀO GIỎ</button>
                            </div>
                        </div>
                        <div class="product-similar-sale-off">
                            <span class="product-similar-item-sale-off">-22%</span>
                        </div>

                    </li>

                </ul>
            </div>



        </div>

    </div>
@endsection
@push('scripts')
    <script>
        // Products-thumb-slider
        const thumbs = document.querySelector(".products-thumb-nav").children;
        console.log(thumbs);

        function changeImage(event) {
            document.querySelector(".products-thumb-imgg").src = event.children[0].src
            for (let i = 0; i < thumbs.length; i++) {
                thumbs[i].classList.remove("product-thumb-nav-item--active");
            }
            event.classList.add("product-thumb-nav-item--active");
        }

        // Button + -
        $('input.input-qty').each(function() {
            var $this = $(this),
                qty = $this.parent().find('.is-form'),
                min = Number($this.attr('min')),
                max = Number($this.attr('max'))
            if (min == 0) {
                var d = 0
            } else d = min
            $(qty).on('click', function() {
                if ($(this).hasClass('minus')) {
                    if (d > min) d += -1
                } else if ($(this).hasClass('plus')) {
                    var x = Number($this.val()) + 1
                    if (x <= max) d += 1
                }
                $this.attr('value', d).val(d)
            })
        })
    </script>
@endpush
