@extends('layout.siteLayout')
@section('title')
    @lang('website.favorite')
@endsection

@section('content')

<div class="page_container">

    <div class="cards_container">


        @foreach($items as $one)
        <div class="like-video-card">
            <div style="position: relative;">
                <img src="{{@$one->video->image}}" alt="Avatar" style="width: 100% ; height: 160px ;">
                <a href="{{route('videos',[@$one->video->course->id,@$one->video->id,slugURL(@$one->video->course->name)])}}"><i class="fa fa-youtube-play" style=" position: absolute; top: 50%; left: 50%; margin: -25px 0 0 -25px ;font-size:48px;color:red"></i></a>
            </div>

            <div class="like-video-container" style="overflow:auto;">
                <h4 style="float:right;"><b>{{@$one->video->name}}</b></h4>
                <div style="float:left;height: 70px;"  class="{{$one->video->is_favorite?'btn-remove-favorite heart is-active':'heart btn-add-favorite'}}" data-id="{{@$one->video->id}}"></div>

            </div>
        </div>

        @endforeach

    </div>
</div>

@endsection

@section('js')

@endsection


@section('script')

@endsection
