@extends('layout.siteLayout')
@section('title')
{{$faculty->name}}
@endsection

@section('content')
<div class="page_container">


    <div class="main-container">

        <div class="row">
            <div class="col-md-12">
                <div class="card-block">
                    <div class="bc-icons-2">

                        <ol class="breadcrumb lighten-4" dir="rtl">

                            <li style="align-self: center"><h2 class="breadcrumb-college-name">{{$faculty->name}}</h2>
                            </li>
                            <div class="line"></div>

                            <div class="breadcrumb-items-container">
                                <li class="breadcrumb-item"><a class="black-text" href="{{url('')}}">@lang('website.home')</a><i
                                        class="fa fa-angle-double-left mx-2" aria-hidden="true"></i></li>
                                <li class="breadcrumb-item"><a class="black-text" href="{{url('')}}">@lang('website.faculty')</a><i
                                        class="fa fa-angle-double-left mx-2" aria-hidden="true"></i></li>
                                <li class="breadcrumb-item active">{{$department->name}}</li>
                            </div>

                            <li><img class="breadcrumb-image" src="{{$faculty->image}}"></li>
                        </ol>

                    </div>
                </div>
            </div>
        </div>



        <div class="courses-container">


            <div class="accordion">
                <h1 class="season_title">@lang('website.first_semester')</h1>

                @foreach($items->where('semester_id','1')  as $one)
                <div class="accordion-item">
                    <button id="accordion-button-1" aria-expanded="false">
                        @if(@$one->main_video->id)
                        <a href="{{route('videos',[$one->id,@$one->main_video->id,slugURL($one->name)])}}" class="play-icon"><img src="{{url('website/images/play.png')}}" width="45px" style="display: inline-block;"></a>
                        @endif
                            <a href="{{route('files',[$one->id,slugURL($one->name)])}}" class="file-icon"><img src="{{url('website/images/folder.png')}}" width="33px" style="display: inline-block;"></a>
                        <span class="accordion-title">{{$one->name}}</span>
                    </button>
                    <div class="accordion-content">
                        <p>
                            يتناول هذا المساق المهارات المستخدمة في تصميم صفحات الإنترنت حيث يتم التركيز على تصميم
                            النهاية الأمامي (Front end) للموقع الإلكتروني. يتعلم الطالب أساسيات برمجة الصفحات باستخدام
                            HTML5 ومن ثم تنسيق هذه الصفحات وهيكلتها باستخدام CSS3. كذلك يتناول المساق لغات البرمجة
                            JavaScript و JQuery واستخداماتها للتفاعل مع محتوى الصفحات الإلكترونية.
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="accordion">
                <h1 class="season_title">@lang('website.second_semester')</h1>

                @foreach($items->where('semester_id','2') as $one)
                    <div class="accordion-item">
                        <button id="accordion-button-1" aria-expanded="false">

                            @if(@$one->main_video->id)
                            <a href="{{route('videos',[$one->id,@$one->main_video->id,slugURL($one->name)])}}" class="play-icon"><img src="{{url('website/images/play.png')}}" width="45px" style="display: inline-block;"></a>
                            @endif
                            <a href="{{route('files',[$one->id,slugURL($one->name)])}}" class="file-icon"><img src="{{url('website/images/folder.png')}}" width="33px" style="display: inline-block;"></a>
                            <span class="accordion-title">{{$one->name}}</span>
                        </button>
                        <div class="accordion-content">
                            <p>
                                يتناول هذا المساق المهارات المستخدمة في تصميم صفحات الإنترنت حيث يتم التركيز على تصميم
                                النهاية الأمامي (Front end) للموقع الإلكتروني. يتعلم الطالب أساسيات برمجة الصفحات باستخدام
                                HTML5 ومن ثم تنسيق هذه الصفحات وهيكلتها باستخدام CSS3. كذلك يتناول المساق لغات البرمجة
                                JavaScript و JQuery واستخداماتها للتفاعل مع محتوى الصفحات الإلكترونية.
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>



    </div>

</div>
</div>

@endsection

@section('js')

@endsection


@section('script')

@endsection
