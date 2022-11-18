@extends('layouts.g-shock')

@section('content')
    <style>
        #wrapper {
            max-width: 100%;
            margin: 0 auto;
        }

        /* Category */
        .list {
            display: flex;
            width: 100%;
        }

        .category {
            margin-top: 136px !important;
            margin-left: 50px !important;
            width: 20%;
            padding: 20px 0px 0px;
            margin: 0px 0px 24px;
            border: solid 1px black;
        }

        .category-heading {
            font-size: 16px;
            color: #DD3333;
            padding: 20px;

        }

        .category-list {
            margin-top: 20px;
        }

        .category-item {
            align-items: center;
            list-style: none;
            padding: 5px 20px;
            height: 45.5px;
            border: solid 1px #ccc;

        }

        .category-item-link {
            color: #555;
            display: block;
            height: 34.4px;
            padding: 6px 0px;
            text-decoration: none;
        }

        .category-item:hover {
            width: 100%;
            background-color: #DD3333;
        }

        .products-list {
            width: 80%;
            height: 300px;
        }

        .products-cat-discount {
            text-decoration: none;
            color: #555;
            font-size: 15px;
        }

        .products-amount-discount {
            text-decoration: none;
            color: #000;
            font-weight: lighter;
            font-size: 20px;
            font-weight: 900;
        }

        .products-amount-cost {
            font-size: 17px;
            text-decoration: none;
            color: #ccc;
            text-decoration-line: line-through;
        }

        .products-btn {
            text-align: center;
            margin-top: 5px;
        }

        .products-btn-add {
            padding: 10px;
            font-weight: 800;
            background-color: rgb(123, 122, 123);
            color: #fff;
        }

        .products-btn-add:hover {
            background-color: rgb(58, 57, 57);
        }

        ul.products {
            display: flex;
            list-style: none;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: 0;
            padding: 100px;
        }

        ul.products li {
            flex-basis: 25%;
        }

        .products-info {
            text-align: center;
            line-height: 1.3;
            margin: 0 8px;
            padding: 15px 0;
            transition: all 0.3s ease-in-out;
        }

        .products-item:hover .products-info {
            background-color: rgb(65, 59, 59);
            transform: scale(1.1);
        }

        .products-item:hover .products-thumb-img {
            transform: scale(1.1);
        }

        .products-thumb-img {
            max-width: 100%;
            height: auto;
        }

        .products-thumb {
            transition: all 0.3s ease-in-out;
            padding: 20px 20px;
        }

        .footer-basic {
            bottom: -1000px;
            position: relative;
            width: 100%;
        }

        nav {
            position: relative;
            left: 42%;
            top: 39px;
        }
    </style>
    <div id="wrapper">
        <div class="list">
            <div class="category">
                <span class="category-heading">DANH MỤC SẢN PHẨM</span>
                <ul class="category-list">
                    @foreach ($cats as $item)
                        <li class="category-item">
                            <a class="category-item-link" href="">{{ $item->cat_name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="products-list">
                <ul class="products">
                    @foreach ($products as $item)
                        <li>
                            <div class="products-item">
                                <div class="products-top">
                                    <a href="{{ route('detailProduct', ['product' => $item->product_name, 'id' => $item->id]) }}"
                                        class="products-thumb">
                                        <img class="products-thumb-img" src="{{ asset($item->product_thumb) }}"
                                            alt="">
                                    </a>
                                </div>
                                <div class="products-info">
                                    <a href="" class="products-cat-discount">{{ $item->product_name }} <br> </a>
                                    <a href="" class="products-amount-cost">{{ currency_format($item->price) }}</a>
                                    <a href=""
                                        class="products-amount-discount">{{ currency_format($item->old_price) }}</a>
                                </div>
                                <div class="products-btn">
                                    <button class="products-btn-add">THÊM VÀO GIỎ</button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                    {{ $products->links() }}
                </ul>
            </div>

        </div>

    </div>
@endsection
