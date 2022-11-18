<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G-SHOCK</title>
    <link rel="stylesheet" href="{{ asset('public/style.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
</head>

<body>

    <div id="main">
        <div id="header">

            <ul id="nav">
                <li class="menu-item">
                <li><a href="">TRANG CHỦ</a></li>
                <li><a href="">GIỚI THIỆU</a></li>
                <li>
                    <a href="{{ route('product') }}">
                        SHOP
                        <i class="nav-arrow-down ti-angle-down"></i>
                    </a>
                    <ul class="subnav">
                        <li><a href="">Aviator</a></li>
                        <li><a href="">Baby-G</a></li>
                        <li><a href="">Edifice</a></li>
                        <li><a href="">G-Shock</a></li>
                        <li><a href="">G-Steel</a></li>
                        <li><a href style=" width: 160px ;">Gravity Master</a></li>
                        <li><a href="">Mudmaster</a></li>
                    </ul>
                </li>
                <li><a href="">TIN TỨC</a></li>
                <li><a href="">LIÊN HỆ</a></li>
                </li>
            </ul>

            <div class="logo">
                <a href="">
                    <img width="250" style="height: 40px;
                    margin-bottom: 20px;"
                        src="https://logos-download.com/wp-content/uploads/2016/09/G-Shock_logo_black.png"
                        alt="gwatch">
                </a>
            </div>

            <div class="search">
                <input type="text" class="searchTerm" placeholder="Tìm kiếm...">
                <button type="submit" class="searchButton">
                    <i class="fa fa-search"></i>
                </button>
            </div>

            <div class="cart">
                <a href="#" class="position-relative" style="right: 40px">
                    <p class="num-order position-absolute">1</p>
                    GIỎ HÀNG
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
            </div>

        </div>

        @yield('slider')
        

    </div>
    <div class="wrapper">
        @yield('home')
        @yield('content')
        <div class="footer-basic">
            <footer>
                <div class="social"><a href="#"><i class="icon ion-social-instagram"></i></a><a
                        href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i
                            class="icon ion-social-twitter"></i></a><a href="#"><i
                            class="icon ion-social-facebook"></i></a></div>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="#">Trang chủ</a></li>
                    <li class="list-inline-item"><a href="#">Giới thiệu</a></li>
                    <li class="list-inline-item"><a href="#">Shop</a></li>
                    <li class="list-inline-item"><a href="#">Tin tức</a></li>
                    <li class="list-inline-item"><a href="#">Liên hệ</a></li>
                </ul>
                <p class="copyright">G-SHOCK © 2022</p>
            </footer>
        </div>
        @stack('scripts')
    </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
        </script>
        <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
        <!-- Initialize Swiper -->
        <script>
            var swiper = new Swiper(".mySwiper", {
                slidesPerView: 4,
                spaceBetween: 20,
                slidesPerGroup: 3,
                loop: true,
                loopFillGroupWithBlank: true,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
            var swiper = new Swiper(".mySwiperNew", {
                slidesPerView: 3,
                spaceBetween: 20,
                slidesPerGroup: 3,
                loop: true,
                loopFillGroupWithBlank: true,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        </script>
</body>

</html>
