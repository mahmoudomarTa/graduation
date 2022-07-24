@extends('layout.siteLayout')
@section('title')
    {{$main_video->name}}
@endsection

@section('content')

<div class="page_container">


    <div class="main-container">

{{--        <div class="row">--}}
{{--            <div class="col-md-12">--}}
{{--                <div class="card-block">--}}
{{--                    <div class="bc-icons-2">--}}

{{--                        <ol class="breadcrumb lighten-4" dir="rtl">--}}

{{--                            <li style="align-self: center"><h2 class="breadcrumb-college-name">{{@$course->name}}</h2>--}}
{{--                            </li>--}}
{{--                            <div class="line"></div>--}}

{{--                            <div class="breadcrumb-items-container">--}}
{{--                                <li class="breadcrumb-item"><a class="black-text" href="{{url('')}}">@lang('website.home')</a><i--}}
{{--                                        class="fa fa-angle-double-left mx-2" aria-hidden="true"></i></li>--}}
{{--                                <li class="breadcrumb-item"><a class="black-text" href="{{url('')}}">@lang('website.faculty')</a><i--}}
{{--                                        class="fa fa-angle-double-left mx-2" aria-hidden="true"></i></li>--}}
{{--                                <li class="breadcrumb-item active">{{@$course->department->name}}</li><i--}}
{{--                                    class="fa fa-angle-double-left mx-2" aria-hidden="true"></i></li>--}}

{{--                                <li class="breadcrumb-item"><a class="black-text">{{@$course->name}}</a><i--}}
{{--                                        class="fa fa-angle-double-left mx-2" aria-hidden="true"></i></li>--}}
{{--                                <li class="breadcrumb-item active">@lang('website.videos')</li>--}}
{{--                            </div>--}}

{{--                            <li><img class="breadcrumb-image" src="{{@$course->department->faculty->image}}"></li>--}}
{{--                        </ol>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="video-container">


            <div class="video-list">
                @foreach($items as $one)
                <div class="vid {{$one->id==$main_video->id? 'active' :''}}">
                    <h3 class="video-title"> {{$one->name}} </h3>
                    <div style="position: relative;">
                        <img src="{{$one->image}}" style="width: 150px ; height: 120px ;"/>
                        <a href="{{route('videos',[@$one->course->id,@$one->id,slugURL(@$one->course->name)])}}"><i class="fa fa-youtube-play" style=" position: absolute; top: 50%; left: 50%; margin: -25px 0 0 -25px ;font-size:48px;color:red"></i></a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="main-video">
                <div class="video">
                    <iframe height="450" src="{{$main_video->url}}"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>


                    <div class="placement">
                        <div  class="{{$main_video->is_favorite?'btn-remove-favorite heart is-active':'heart btn-add-favorite'}}" data-id="{{$main_video->id}}"></div>
                        <h3 class="video-title">{{$main_video->name}}</h3>
                    </div>
                    <p class="video-description">
                        {{$main_video->description}}
                    </p>
                </div>

                <div class="comments-app" ng-app="commentsApp" ng-controller="CommentsController as cmntCtrl"dir="rtl">
                    <div class="comment-form">
                        <!-- Comment Avatar -->
{{--                        <div class="comment-avatar">--}}
{{--                            <img src="../images/persons/person1.png" >--}}
{{--                        </div>--}}

                        <form class="form" method="post" action="{{route('comment',[$main_video->id])}}">
                            <div class="form-row">
                                <textarea name="comment" id="comment_message" class="input" placeholder="@lang('website.add_comment')"
                                        required></textarea>
                            </div>

                            <div class="form-row">
                                <input type="submit" value="@lang('website.send')">
                            </div>
                        </form>
                    </div>

                    <!-- Comments List -->
                    <div class="comments">
                        <div class="comments-messages">
                            @include('includes.comments')
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>


@endsection

@section('js')


<script>
    $(document).on('submit','.form', function(e){
        e.preventDefault();
        var form = $(this);
        $.ajax({
            type: form.attr('method'),
            headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
            url: form.attr('action'),
            data: form.serialize(),
            success: function (response) {
                $('#comment_message').val('');
                $('.comments-messages').html(response.html);
            },
            error: function (jqXHR, error, errorThrown) {

            }
        });
    });
</script>
@endsection


@section('script')

@endsection
