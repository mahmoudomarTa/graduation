@extends('layout.siteLayout')
@section('title')
    {{$course->name}}
@endsection

@section('content')

<div class="page_container">

    <div class="row">
        <div class="col-md-12">
            <div class="card-block">
                <div class="bc-icons-2">

                    <ol class="breadcrumb lighten-4" dir="rtl">
                        <li style="align-self: center"><h2 class="breadcrumb-college-name">{{@$course->name}}</h2>
                        </li>
                        </ol>

                </div>
            </div>
        </div>
    </div>

    <div class="cards_container">

        @foreach($items as $one)
        <a href="{{$one->file}}" download class="card education">
            <div class="overlay"></div>
            <div class="circle"><img src="{{fileImage()}}" style="width: 80px;z-index: 1;"></div>
            <p>{{$one->name}}</p>
        </a>
        @endforeach

    </div>



</div>

@endsection

@section('js')

@endsection


@section('script')

@endsection
