@extends('layout.siteLayout')
@section('title')
@lang('website.requirements')
@endsection

@section('content')

<div class="page_container">


    <div class="row">
        <div class="col-md-12">
            <div class="card-block">
                <div class="bc-icons-2">

                    <ol class="breadcrumb lighten-4" dir="rtl">

                        <li style="align-self: center"><h2 class="breadcrumb-college-name">@lang('website.requirements')</h2></li>
                    </ol>

                </div>
            </div>
        </div>
    </div>


    <div class="main-container">

        <div class="sectionCards">

            @foreach($items as $one)
            <div class="wrapper">
                <div class="sectionCard">
                    <i class="fas fa-arrow-left" style="color: white"></i>
                    <h2 class="card__title" dir="rtl">{{$one->name}}</h2>
                </div>
                <input type="checkbox"/>
                <div class="fac">
                        <a {{$one->main_video ? 'href='.  route('requirementVideos',[$one->id ,$one->main_video, $one->name]) : ''}} >{{$one->main_video ? __('website.videos'):__('website.no_videos')}}</a>
                        <hr style="width: 100%;background: black;opacity: .5">

                        <a href="{{route('requirementFiles',[$one->id , $one->name])}}"> @lang('website.files')</a>
                        <hr style="width: 100%;background: black;opacity: .5">

                   </div>
            </div>

            @endforeach

        </div>


    </div>
</div>

@endsection

@section('js')


@endsection


@section('script')

@endsection
