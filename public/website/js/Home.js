// ---------Responsive-navbar-active-animation-----------
function test(){
    var tabsNewAnim = $('#navbarSupportedContent');
    var selectorNewAnim = $('#navbarSupportedContent').find('li').length;
    var activeItemNewAnim = tabsNewAnim.find('.active');
    var activeWidthNewAnimHeight = activeItemNewAnim.innerHeight();
    var activeWidthNewAnimWidth = activeItemNewAnim.innerWidth();
    var itemPosNewAnimTop = activeItemNewAnim.position();
    var itemPosNewAnimLeft = activeItemNewAnim.position();
    $(".hori-selector").css({
        "top":itemPosNewAnimTop.top + "px",
        "left":itemPosNewAnimLeft.left + "px",
        "height": activeWidthNewAnimHeight + "px",
        "width": activeWidthNewAnimWidth + "px"
    });
    $("#navbarSupportedContent").on("click","li",function(e){
        $('#navbarSupportedContent ul li').removeClass("active");
        $(this).addClass('active');
        var activeWidthNewAnimHeight = $(this).innerHeight();
        var activeWidthNewAnimWidth = $(this).innerWidth();
        var itemPosNewAnimTop = $(this).position();
        var itemPosNewAnimLeft = $(this).position();
        $(".hori-selector").css({
            "top":itemPosNewAnimTop.top + "px",
            "left":itemPosNewAnimLeft.left + "px",
            "height": activeWidthNewAnimHeight + "px",
            "width": activeWidthNewAnimWidth + "px"
        });
    });
}
$(document).ready(function(){
    setTimeout(function(){ test(); });
});
$(window).on('resize', function(){
    setTimeout(function(){ test(); }, 500);
});
$(".navbar-toggler").click(function(){
    $(".navbar-collapse").slideToggle(300);
    setTimeout(function(){ test(); });
});



// --------------add active class-on another-page move----------
jQuery(document).ready(function($){
    // Get current path and find target link
    var path = window.location.pathname.split("/").pop();

    // Account for home page with empty path
    if ( path == '' ) {
        path = 'index.html';
    }

    var target = $('#navbarSupportedContent ul li a[href="'+path+'"]');
    // Add active class to target link
    target.parent().addClass('active');
});

/*----------slider-js------------*/

$('.brand-carousel').owlCarousel({
    loop:true,
    margin:10,
    autoplay:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})


/*----------courses-js------------*/

// const items = document.querySelectorAll(".accordion button");
//
// function toggleAccordion() {
//     const itemToggle = this.getAttribute('aria-expanded');
//
//     for (i = 0; i < items.length; i++) {
//         items[i].setAttribute('aria-expanded', 'false');
//     }
//
//     if (itemToggle == 'false') {
//         this.setAttribute('aria-expanded', 'true');
//     }
// }
//
// items.forEach(item => item.addEventListener('click', toggleAccordion));


/*----------coursesVideos.js------------*/


let listVideo = document.querySelectorAll('.video-list .vid');
let mainVideo = document.querySelector('.main-video .video');
let titleVideo = document.querySelector('.main-video .video-title');

listVideo.forEach(video => {
    video.onclick = () => {
        listVideo.forEach(vid => vid.classList.remove('active'));
        video.classList.add('active');
        if (video.classList.contains('active')) {
            let src = video.children[0].getAttribute('src');
            mainVideo.src = src;

            let text = video.children[1].innerHTML;
            titleVideo.innerHTML = text;
        }
        ;
    };
});


/*----------comments.js------------*/

(function(){
    'use strict';

    angular
        .module('commentsApp', [])
        .controller('CommentsController', CommentsController);

    // Inject $scope dependency.
    CommentsController.$inject = ['$scope'];

    // Declare CommentsController.
    function CommentsController($scope) {
        var vm = this;

        // Current comment.
        vm.comment = {};

        // Array where comments will be.
        vm.comments = [];

        // Fires when form is submited.
        vm.addComment = function() {
            // Fixed img.
          //  vm.comment.avatarSrc = 'http://lorempixel.com/200/200/people/';
            vm.comment.avatarSrc = '../images/persons/person1.png';

            // Add current date to the comment.
            vm.comment.date = Date.now();

            vm.comments.push( vm.comment );
            vm.comment = {};

            // Reset clases of the form after submit.
            $scope.form.$setPristine();
        }

        // Fires when the comment change the anonymous state.
        vm.anonymousChanged = function(){
            if(vm.comment.anonymous)
                vm.comment.author = "";
        }
    }

})();


// /*----------SignIn.js------------*/
//
//
// var overlay = document.getElementById("signIn_overlay");
//
// // Buttons to 'switch' the page
// var openSignUpButton = document.getElementById("slide-left-button");
// var openSignInButton = document.getElementById("slide-right-button");
//
// // The sidebars
// var leftText = document.getElementById("sign-in");
// var rightText = document.getElementById("sign-up");
//
// // The forms
// var accountForm = document.getElementById("sign-in-info")
// var signinForm = document.getElementById("sign-up-info");
//
// // Open the Sign Up page
// openSignUp = () => {
//     // Remove classes so that animations can restart on the next 'switch'
//     leftText.classList.remove("overlay-text-left-animation-out");
//     overlay.classList.remove("open-sign-in");
//     rightText.classList.remove("overlay-text-right-animation");
//     // Add classes for animations
//     accountForm.className += " form-left-slide-out"
//     rightText.className += " overlay-text-right-animation-out";
//     overlay.className += " open-sign-up";
//     leftText.className += " overlay-text-left-animation";
//     // hide the sign up form once it is out of view
//     setTimeout(function () {
//         accountForm.classList.remove("form-left-slide-in");
//         accountForm.style.display = "none";
//         accountForm.classList.remove("form-left-slide-out");
//     }, 700);
//     // display the sign in form once the overlay begins moving right
//     setTimeout(function () {
//         signinForm.style.display = "flex";
//         signinForm.classList += " form-right-slide-in";
//     }, 200);
// }
//
// // Open the Sign In page
// openSignIn = () => {
//     // Remove classes so that animations can restart on the next 'switch'
//     leftText.classList.remove("overlay-text-left-animation");
//     overlay.classList.remove("open-sign-up");
//     rightText.classList.remove("overlay-text-right-animation-out");
//     // Add classes for animations
//     signinForm.classList += " form-right-slide-out";
//     leftText.className += " overlay-text-left-animation-out";
//     overlay.className += " open-sign-in";
//     rightText.className += " overlay-text-right-animation";
//     // hide the sign in form once it is out of view
//     setTimeout(function () {
//         signinForm.classList.remove("form-right-slide-in")
//         signinForm.style.display = "none";
//         signinForm.classList.remove("form-right-slide-out")
//     }, 700);
//     // display the sign up form once the overlay begins moving left
//     setTimeout(function () {
//         accountForm.style.display = "flex";
//         accountForm.classList += " form-left-slide-in";
//     }, 200);
// }
//
// // When a 'switch' button is pressed, switch page
// openSignUpButton.addEventListener("click", openSignUp, false);
// openSignInButton.addEventListener("click", openSignIn, false);
