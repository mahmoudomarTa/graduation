@extends('layout.siteLayout')
@section('title')
    {{$setting->title}}
@endsection

@section('content')
    <div class="page_container">


    <div class="cards_container">

        <a href="{{route('requirements')}}" class="card education">
            <div class="overlay"></div>
            <div class="circle"><img src="{{url('website/images/bookshelf.png')}}" style="width: 80px;z-index: 1;"></div>
            <p>@lang('website.requirements')</p>
        </a>

        @foreach($items as $one)
        <a href="{{route('departments',[$one->id,slugURL($one->name)])}}" class="card education">
            <div class="overlay"></div>
            <div class="circle"><img src="{{$one->image}}" style="width: 80px;z-index: 1;"></div>
            <p>{{$one->name}}</p>
        </a>
        @endforeach
    </div>

    <div class="sm:flex items-center max-w-screen-xl">

        <div class="sm:w-1/2 p-5">
            <div class="text" style="text-align: right">
{{--                <span class="text-gray-500 border-b-2 border-indigo-600 uppercase">من نحن ؟</span>--}}
                <h2 class="my-4 font-bold text-3xl  sm:text-4xl ">@lang('website.about') <span class="text-indigo-600">@lang('website.app_name')</span>
                </h2>
                <p class="text-gray-700">

                    أسس مركز التعليم الالكتروني في الجامعة الإسلامية في عام 2001 م بهدف دعم وتسهيل
                    استخدام التقنيات الحديثة من حاسوب واتصالات في العملية التعليمة. وتعد خدمة تقديم المساقات في صيغتها
                    الإلكترونية عبر أنظمة إدارة التعليم الإلكتروني من خلال شبكة الإنترنت من أهم الخدمات التي يقدمها
                    المركز، إضافة إلى خدمات أخرى مثل تدريب الأساتذة على تصميم المساقات التعليمية الإلكترونية وتدريب
                    الطلبة على استخدامها بأمثل الطرق. كما يقدم المركز خدمات معينة التدريب لتشمل شرائح مختلفة من المجتمع
                    الفلسطيني لاسيما المهتمين بالتعليم الإلكتروني والتعليم ما قبل الجامعي من أساتذة ومطوري مناهج وسياسات
                    التعليم على مستوى الوطن.

                </p>
            </div>
        </div>

        <div class="sm:w-1/2 p-10">
            <div class="image object-center text-center">
                <img src="https://www.pentame.ae/images/about-us.svg">
            </div>
        </div>

    </div>

{{--    <div class="brand-carousel section-padding owl-carousel">--}}

{{--        @foreach($partners as $one)--}}
{{--            <div class="single-logo">--}}
{{--                <img src="{{$one->image}}" alt="img">--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--     --}}
{{--    </div>--}}


</div>
@endsection

@section('js')

@endsection


@section('script')

@endsection
