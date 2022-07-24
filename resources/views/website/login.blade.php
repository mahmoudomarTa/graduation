<html lang="{{app()->getLocale()}}" dir="{{(app()->getLocale() == 'ar') ? 'rtl' : 'ltr'}}">

<head>
    <meta charset="UTF-8">
    <title>@lang('website.sign_in')</title>
    <link rel="stylesheet" type="text/css" href="{{url('website/css/style.css')}}">

</head>

<body>
@if (count($errors) > 0)
    <div class="container pt30">
        <div class="alert alert-custom alert-white alert-shadow gutter-b" role="alert">
            <div class="alert alert-danger" style="color:red">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }} </p>
                @endforeach
            </div>

        </div>
    </div>
@endif
<div class="signIn_container">
    <div class="signIn_overlay" id="signIn_overlay">
        <div class="sign-in" id="sign-in">
            <h1>@lang('website.hi_there')</h1>
            <p>@lang('website.for_be_with_us')</p>
            <button class="switch-button" id="slide-right-button">@lang('website.sign_in')</button>
        </div>
        <div class="sign-up" id="sign-up">
            <h1>@lang('website.hi_there')</h1>
                <p>@lang('website.enter_your_info')</p>
            <button class="switch-button" id="slide-left-button">@lang('website.sign_up')</button>
        </div>
    </div>

    <div class="SignIn-form">
        <div class="sign-in" id="sign-in-info">
            <h1>@lang('website.sign_in')</h1>
            <div class="social-media-buttons">
                <div class="icon">
                  <img class="student-image" src="{{url('website/images/person1.png')}}">
                </div>
            </div>
            <form id="sign-in-form" class="sign-in-form" method="post" action="{{route('loginPost')}}">
                @csrf
                <input type="email" name="email" placeholder="@lang('website.email')"/>
                <input type="password" name="password" placeholder="@lang('website.password')"/>
                <button class="control-button in">@lang('website.sign_in')</button>
            </form>
        </div>


        <div class="sign-up" id="sign-up-info">
            <h1>@lang('website.sign_up')</h1>
            <div class="social-media-buttons">
                <div class="icon">
                  <img class="student-image" src="{{url('website/images/person1.png')}}">
                </div>
            </div>
            <form id="sign-up-form" method="post" action="{{route('registerPost')}}">
                @csrf
                <input type="text" name="name" placeholder="@lang('website.user_name')"/>
                <input type="email" name="email" placeholder="@lang('website.email')"/>
                <input type="number" name="mobile" placeholder="@lang('website.mobile')"/>
                <input type="password" name="password" placeholder="@lang('website.password')"/>
                <input type="password" name="confirm_password" placeholder="@lang('website.confirm_password')"/>
                <button class="control-button up">@lang('website.sign_up')</button>
            </form>
        </div>

    </div>
</div>
<script type="text/javascript" src="{{url('website/js/Home.js')}}"></script>
<script>
    var overlay = document.getElementById("signIn_overlay");

    // Buttons to 'switch' the page
    var openSignUpButton = document.getElementById("slide-left-button");
    var openSignInButton = document.getElementById("slide-right-button");

    // The sidebars
    var leftText = document.getElementById("sign-in");
    var rightText = document.getElementById("sign-up");

    // The forms
    var accountForm = document.getElementById("sign-in-info")
    var signinForm = document.getElementById("sign-up-info");

    // Open the Sign Up page
    openSignUp = () => {
        // Remove classes so that animations can restart on the next 'switch'
        leftText.classList.remove("overlay-text-left-animation-out");
        overlay.classList.remove("open-sign-in");
        rightText.classList.remove("overlay-text-right-animation");
        // Add classes for animations
        accountForm.className += " form-left-slide-out"
        rightText.className += " overlay-text-right-animation-out";
        overlay.className += " open-sign-up";
        leftText.className += " overlay-text-left-animation";
        // hide the sign up form once it is out of view
        setTimeout(function () {
            accountForm.classList.remove("form-left-slide-in");
            accountForm.style.display = "none";
            accountForm.classList.remove("form-left-slide-out");
        }, 700);
        // display the sign in form once the overlay begins moving right
        setTimeout(function () {
            signinForm.style.display = "flex";
            signinForm.classList += " form-right-slide-in";
        }, 200);
    }

    // Open the Sign In page
    openSignIn = () => {
        // Remove classes so that animations can restart on the next 'switch'
        leftText.classList.remove("overlay-text-left-animation");
        overlay.classList.remove("open-sign-up");
        rightText.classList.remove("overlay-text-right-animation-out");
        // Add classes for animations
        signinForm.classList += " form-right-slide-out";
        leftText.className += " overlay-text-left-animation-out";
        overlay.className += " open-sign-in";
        rightText.className += " overlay-text-right-animation";
        // hide the sign in form once it is out of view
        setTimeout(function () {
            signinForm.classList.remove("form-right-slide-in")
            signinForm.style.display = "none";
            signinForm.classList.remove("form-right-slide-out")
        }, 700);
        // display the sign up form once the overlay begins moving left
        setTimeout(function () {
            accountForm.style.display = "flex";
            accountForm.classList += " form-left-slide-in";
        }, 200);
    }

    // When a 'switch' button is pressed, switch page
    openSignUpButton.addEventListener("click", openSignUp, false);
    openSignInButton.addEventListener("click", openSignIn, false);

    var loadFile = function (event) {
        var image = document.getElementById("output");
        image.src = URL.createObjectURL(event.target.files[0]);
    };

    var loadFile2 = function (event) {
        var image = document.getElementById("output2");
        image.src = URL.createObjectURL(event.target.files[0]);
    };

</script>
</body>
</html>
