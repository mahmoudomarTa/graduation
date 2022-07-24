@extends('layout.siteLayout')
@section('title')
    @lang('website.edit_profile')
@endsection

@section('content')

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


<div class="add-modal" id="page">
    <div class="modal__container">
        <div class="modal__featured">
            <div class="modal__circle"></div>
            <img src="{{url('website/images/agreement.png')}}" class="modal__add">
        </div>
        <div class="modal__content">
            <h2 style="margin-bottom: 20px;">@lang('website.edit_profile')</h2>

            <form method="post" action="{{route('updateMyProfile')}}" >
                @csrf
                <ul class="form-list">
                    <li class="form-list__row" style="margin-top: 50px">
                        <label>@lang('website.user_name')</label>
                        <input type="text" name="name" class="play_list_input" value="{{auth('web')->user()->name}}" required/>
                    </li>

                    <li class="form-list__row">
                        <label>@lang('website.email')</label>
                        <input type="email" name="email" class="play_list_input" value="{{auth('web')->user()->email}}" required/>
                    </li>

                    <li class="form-list__row">
                        <label>@lang('website.mobile')</label>
                        <input type="number" name="mobile" class="play_list_input" value="{{auth('web')->user()->mobile}}" required/>

                    </li>

                    <li style="margin-top: 20px">
                        <button type="submit" class="button-add">@lang('website.edit')</button>
{{--                        <button type="submit" class="button-cancel">إلغاء</button>--}}
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')


@endsection


@section('script')

@endsection
