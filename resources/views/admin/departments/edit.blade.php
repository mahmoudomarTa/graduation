@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.departments'))}}
@endsection
@section('css')

    <style>
        a:link {
            text-decoration: none;
        }
    </style>

@endsection
@section('content')


    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h3>{{__('cp.edit_department')}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{url(getLocal().'/admin/departments')}}" class="btn btn-secondary  mr-2">{{__('cp.cancel')}}</a>
                    <button id="submitButton" class="btn btn-success ">{{__('cp.edit')}}</button>
                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <form method="post" action="{{url(app()->getLocale().'/admin/departments/'.$item->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                        {{ csrf_field() }}
                        {{ method_field('PATCH')}}
                        <div class="card-header">
                            <h3 class="card-title">{{__('cp.main_info')}}</h3>
                        </div>
                        <div class="row col-sm-12">
                            <div class="card-body">
                                <div class="row">
                                    @foreach($locales as $locale)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('cp.name_'.$locale->lang)}}</label>
                                                <input type="text" class="form-control form-control-solid"
                                                       name="name_{{$locale->lang}}" {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} value="{{old('name_'.$locale->lang,@$item->translate($locale->lang)->name)}}" required />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>



                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.faculty')}}</label>
                                            <select   class="form-control form-control-solid"
                                                      name="faculty_id" required>
                                                <option value="">
                                                    {{__('cp.select')}}
                                                </option>
                                                @foreach($faculties as $one)
                                                    <option value="{{$one->id}}" {{$one->id==$item->faculty_id?'selected':''}}>
                                                        {{$one->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> {{__('cp.years')}}</label>
                                            <select class="form-control form-control-solid select2" id="years" name="years[]"
                                                    multiple="multiple" required>

                                                @foreach($years as $one)
                                                    <option value="{{$one->id}}" {{in_array($one->id,old('years',@$item->years->pluck('year_id')->toArray())) ? "selected":"" }}>{{$one->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.status')}}</label>
                                            <select   class="form-control form-control-solid"
                                                      name="status" required>
                                                <option
                                                    value="active" {{$item->status == 'active'?'selected':''}}>
                                                    {{__('cp.active')}}
                                                </option>
                                                <option
                                                    value="not_active" {{$item->status == 'not_active'?'selected':''}}>
                                                    {{__('cp.not_active')}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
{{--                        <div class="card-header">--}}
{{--                            <h3 class="card-title">{{__('cp.image')}}</h3>--}}
{{--                        </div>--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="form-group">--}}
{{--                                <div class="col-md-6 col-md-offset-3">--}}
{{--                                    <div class="fileinput-new thumbnail"--}}
{{--                                         onclick="document.getElementById('edit_image').click()"--}}
{{--                                         style="cursor:pointer">--}}
{{--                                        <img src="{{$item->image}}" id="editImage" alt="{{$item->name}}">--}}
{{--                                    </div>--}}
{{--                                    <div class="btn red"--}}
{{--                                         onclick="document.getElementById('edit_image').click()">--}}
{{--                                        <i class="fa fa-pencil"></i>--}}
{{--                                    </div>--}}
{{--                                    <input type="file" class="form-control" name="image"--}}
{{--                                           id="edit_image"--}}
{{--                                           style="display:none">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <button type="submit" id="submitForm" style="display:none"></button>
                    </form>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>


@endsection
@section('js')

    <script>
        $('#edit_image').on('change', function (e) {
            readURL(this, $('#editImage'));
        });
    </script>

@endsection

@section('script')

@endsection
