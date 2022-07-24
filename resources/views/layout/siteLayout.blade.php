<html lang="{{app()->getLocale()}}" dir="{{(app()->getLocale() == 'ar') ? 'rtl' : 'ltr'}}">
<html>
<head>
    <title>
        @yield('title')
    </title>
    <link rel="shortcut icon" href="{{url('logo.png')}}" />
    <link rel="stylesheet" type="text/css"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.6.2/tailwind.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">

    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://pro.fontawesome.com/releases/v5.2.0/css/all.css">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/style.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Tajawal' rel='stylesheet'>


</head>
<body>

<nav class="navbar navbar-expand-custom navbar-mainbg">

    <a class="navbar-brand navbar-logo" href="{{url('')}}" style="display: inherit;align-items: center;"><img
            src="{{url('logo.png')}}"
            style="width: 80px;height: 80px;margin-right: 10px">محاضرات الطالب الجامعي</a>
    <button class="navbar-toggler" type="button" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
        <i class="fas fa-bars text-white"></i>

    </button>
    <div style="margin-right: 100px;" class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <div class="hori-selector">
                <div class="left"></div>
                <div class="right"></div>
            </div>
            <li class="nav-item {{Route::currentRouteName()=='home' ? "active" : ''}}">
                <a class="nav-link" href="{{route('home')}}"><i class="fa fa-home"></i>@lang('website.home')</a>
            </li>
            <li class="nav-item {{Route::currentRouteName()=='about' ? "active" : ''}}">
                <a class="nav-link " href="{{route('about')}}"><i class="fa fa-info"></i>@lang('website.about_us')</a>
            </li>

            @if(auth('web')->check())
            <li class="nav-item {{Route::currentRouteName()=='profile' ? "active" : ''}}">
                <a class="nav-link" href="{{route('profile')}}"><i class="fa fa-user"></i>@lang('website.profile')</a>
            </li>
            @else
                <li class="nav-item {{Route::currentRouteName()=='login' ? "active" : ''}}">
                    <a class="nav-link" href="{{route('login')}}"><i class="fa fa-user"></i>@lang('website.login')</a>
                </li>
            @endif
            <li class="nav-item">
                @if(getLocal()=='ar')
                    <a href="{{LaravelLocalization::getLocalizedURL('en', null, [], true) }}" ><i class="fa fa-language"></i>@lang('website.english')</a>
                @else
                    <a href="{{LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" ><i class="fa fa-language"></i>@lang('website.arabic')</a>
                @endif
            </li>

        </ul>
    </div>
</nav>


@yield('content')

<footer class="footer">
    <div class="waves">
        <div class="wave" id="wave1"></div>
        <div class="wave" id="wave2"></div>
        <div class="wave" id="wave3"></div>
        <div class="wave" id="wave4"></div>
    </div>
    <ul class="social-icon">
        <li class="social-icon__item"><a class="social-icon__link" href="#">
                <ion-icon name="logo-facebook"></ion-icon>
            </a></li>
        <li class="social-icon__item"><a class="social-icon__link" href="#">
                <ion-icon name="logo-twitter"></ion-icon>
            </a></li>
        <li class="social-icon__item"><a class="social-icon__link" href="#">
                <ion-icon name="logo-linkedin"></ion-icon>
            </a></li>
        <li class="social-icon__item"><a class="social-icon__link" href="#">
                <ion-icon name="logo-instagram"></ion-icon>
            </a></li>
    </ul>
    <ul class="menu" dir="rtl">
        <li class="menu__item"><a class="menu__link" href="#">الرئيسية</a></li>
        <li class="menu__item"><a class="menu__link" href="#">صفحة الجامعة</a></li>
        <li class="menu__item"><a class="menu__link" href="#">من نحن</a></li>
        <li class="menu__item"><a class="menu__link" href="#">اتصل بنا</a></li>
        <li class="menu__item"><a class="menu__link" href="#">الشروط و الاحكام</a></li>

    </ul>
    <p dir="rtl">&copy;جميع حقوق الطبع و النشر محفوظة لدى محاضرات الطالب الجامعي</p>
</footer>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.14/angular.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script type="text/javascript" src="{{url('website/js/Home.js')}}"></script>

<script>
    $(document).on('click','.btn-add-favorite',function (e) {
        // e.preventDefault();
        var ele = $(this);
        var id = $(this).data("id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{url(app()->getLocale().'/add-favorite')}}'+'/'+id,
            method: "get",
            data: {

            },
            success: function (response) {
                ele.removeClass('btn-add-favorite').addClass('btn-remove-favorite');
            }
        });
    });

    $(document).on('click','.btn-remove-favorite',function (e) {
        // e.preventDefault();
        var ele = $(this);
        var id = $(this).data("id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{url(app()->getLocale().'/remove-favorite')}}'+'/'+id,
            method: "get",
            data: {

            },
            success: function (response) {
                {{--ele.html("@lang('website.add_to_cart')");--}}
                ele.removeClass( 'btn-remove-favorite' ).addClass( 'btn-add-favorite' );

                // $("#cart_content").html(response.cartAll);
                // $(".cart-view").html(response.cart);
                // $(".count-quantity").html(response.itemQuantity);
            }
        });
    });

</script>
<script>
    $(function() {
        $(".heart").on("click", function() {
            $(this).toggleClass("is-active");
        });
    });
</script>

{{--<script>--}}
{{--    $(document).on('submit','.form', function(e){--}}
{{--        e.preventDefault();--}}
{{--        var form = $(this);--}}
{{--        $.ajax({--}}
{{--            type: form.attr('method'),--}}
{{--            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},--}}
{{--            url: form.attr('action'),--}}
{{--            data: form.serialize(),--}}
{{--            success: function (response) {--}}
{{--                $('#comment_message').val('');--}}
{{--                $('.comments-messages').html(response.html);--}}
{{--            },--}}
{{--            error: function (jqXHR, error, errorThrown) {--}}

{{--            }--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}


@yield('js')
@yield('script')
</body>
</html>
