@extends('layout.siteLayout')
@section('title')
{{$faculty->name}}
@endsection

@section('content')

<div class="page_container">


    <div class="row">
        <div class="col-md-12">
            <div class="card-block">
                <div class="bc-icons-2">

                    <ol class="breadcrumb lighten-4" dir="rtl">

                        <li style="align-self: center"><h2 class="breadcrumb-college-name">{{$faculty->name}}</h2></li>
                        <div class="line"></div>

                        <div class="breadcrumb-items-container">
                            <li class="breadcrumb-item"><a class="black-text" href="{{url('')}}">@lang('website.home')</a><i
                                    class="fa fa-angle-double-left mx-2" aria-hidden="true"></i></li>
                            <li class="breadcrumb-item"><a class="black-text" href="{{url('')}}">@lang('website.faculty')</a><i
                                    class="fa fa-angle-double-left mx-2" aria-hidden="true"></i></li>
                            <li class="breadcrumb-item active">@lang('website.departments')</li>
                        </div>
                        <li><img class="breadcrumb-image" src="{{$faculty->image}}"></li>
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
                    @foreach($one->years as $year)
                        <a href="{{route('courses',[$one->id,$year->year->id,slugURL($one->name)])}}">{{$year->year->name}}</a>
                        <hr style="width: 100%;background: black;opacity: .5">
                    @endforeach
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
