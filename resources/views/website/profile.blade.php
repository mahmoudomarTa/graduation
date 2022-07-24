@extends('layout.siteLayout')
@section('title')
    @lang('website.profile')
@endsection

@section('content')

<div class="page_container">

<div class="wraper">
    <div class="user-profile-container">

        <div class="main-content">
            <div class="section1 p-30" id="Home">

                <div class="d-flex-align-center">

                    <div class="user-profile flex-1">
                        <div class="pro-details">
                            <div class="sm-text">@lang('website.welcome') </div>
                            <div class="user_name">{{auth('web')->user()->name}}</div>
                        </div>
                        <div class="text">@lang('website.you_can_see')</div>
                        <div class="pr-list">
                            <ul dir="rtl" type="none">
                                <li><i class="fa fa-user" aria-hidden="true" style="color: #3586ff" ></i>{{auth('web')->user()->name}}</li>
                                <li><i class="fa fa-envelope" aria-hidden="true" style="color: #3586ff"></i> {{auth('web')->user()->email}}</li>
                                <li><i class="fa fa-phone" aria-hidden="true" style="color: #3586ff"></i>{{auth('web')->user()->mobile}}</li>
                                <a href="{{route('logout')}}"><li><i class="fa fa-arrow-circle-right" aria-hidden="true" style="color: #3586ff"></i>@lang('website.logout')</li></a>
                            </ul>
                        </div>
                        <div class="profile_icons">
                        <a  href="{{route('favorite')}}" ><img src="{{url('website/images/heart.png')}}" width="40px"></a>
                        <a  href="{{route('editMyProfile')}}" style="margin-left: 20px"><img src="{{url('website/images/edit.png')}}" width="40px" ></a>
                    </div>
                    </div>

                    <div class="user-img-container flex-1">
                        <img class="user-img" src="{{auth('web')->user()->image}}">
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
</div>
@endsection

@section('js')

@endsection


@section('script')

@endsection
