@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.videos'))}}
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
                        <h3>{{__('cp.edit_video')}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{url(getLocal().'/admin/videos')}}" class="btn btn-secondary  mr-2">{{__('cp.cancel')}}</a>
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
                    <form method="post" action="{{url(app()->getLocale().'/admin/videos/'.$item->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                        {{ csrf_field() }}
                        {{ method_field('PATCH')}}
                        <div class="card-header">
                            <h3 class="card-title">{{__('cp.main_info')}}</h3>
                        </div>
                        <div class="row col-sm-12">
                            <div class="card-body">
                                <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('cp.name')}}</label>
                                                <input type="text" class="form-control form-control-solid"
                                                       name="name" value="{{old('name',@$item->name)}}" required />
                                            </div>
                                        </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.url')}}</label>
                                            <input type="text" class="form-control form-control-solid"
                                                   name="url" value="{{old('url',@$item->url)}}" required />
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.faculty')}}</label>
                                            <select   class="form-control form-control-solid"
                                                      id="faculty_id" name="faculty_id" required>
                                                <option value="">
                                                    {{__('cp.select')}}
                                                </option>
                                                @foreach($faculties as $one)
                                                    <option data-id="{{$one->id}}" value="{{$one->id}}" {{old('faculty_id',$item->faculty_id)==$one->id?'selected':''}}>
                                                        {{$one->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> {{__('cp.department')}}</label>
                                            <select class="form-control form-control-solid" id="department_id" name="department_id"
                                                    required>
                                                <option value="">
                                                    {{__('cp.select')}}
                                                </option>
                                                @foreach($departments as $one)
                                                    <option data-id="{{$one->id}}" value="{{$one->id}}" {{old('department_id',$item->department_id)==$one->id?'selected':''}}>
                                                        {{$one->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> {{__('cp.course')}}</label>
                                            <select class="form-control form-control-solid" id="course_id" name="course_id"
                                                    required>
                                                <option value="">
                                                    {{__('cp.select')}}
                                                </option>
                                                @foreach($courses as $one)
                                                    <option data-id="{{$one->id}}" value="{{$one->id}}" {{old('course_id',$item->course_id)==$one->id?'selected':''}}>
                                                        {{$one->name}}
                                                    </option>
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
                                                    value="active" {{old('status',$item->status) == 'active'?'selected':''}}>
                                                    {{__('cp.active')}}
                                                </option>
                                                <option
                                                    value="not_active" {{old('status',$item->status)== 'not_active'?'selected':''}}>
                                                    {{__('cp.not_active')}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{__('cp.description')}}</label>
                                            <textarea type="text" class="form-control form-control-solid"
                                                      name="description"  >{{old('description',$item->description)}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-header col-md-12">
                            <h3 class="card-title">{{__('cp.image')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="fileinput-new thumbnail"
                                         onclick="document.getElementById('edit_image').click()"
                                         style="cursor:pointer">
                                        <img src="{{$item->image}}" id="editImage" alt="{{$item->name}}">
                                    </div>
                                    <div class="btn red"
                                         onclick="document.getElementById('edit_image').click()">
                                        <i class="fa fa-pencil"></i>
                                    </div>
                                    <input type="file" class="form-control" name="image"
                                           id="edit_image"
                                           style="display:none">
                                </div>
                            </div>
                        </div>


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
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {
            $('#faculty_id').on('change', function (e) {
                var id = $(this).find('option:selected').data('id');
                $.ajax({
                    url: "{{ url(getLocal().'/admin/getDepartments') }}",
                    type: "get",
                    data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('#department_id').empty();
                        $('#department_id').attr("disabled", false);
                        $('#department_id').append('<option value="">' + "@lang('cp.choose')" + '</option>');
                        $.each(data.items, function (index, one) {
                            $('#department_id').append('<option value="' + one.id + '"  data-id="' + one.id + '">' + one .name + '</option>');
                        })

                    }
                })
            });
        });


        $(document).ready(function () {
            $('#department_id').on('change', function (e) {
                var id = $(this).find('option:selected').data('id');
                $.ajax({
                    url: "{{ url(getLocal().'/admin/getCourses') }}",
                    type: "get",
                    data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('#course_id').empty();
                        $('#course_id').attr("disabled", false);
                        $('#course_id').append('<option value="">' + "@lang('cp.choose')" + '</option>');
                        $.each(data.items, function (index, one) {
                            $('#course_id').append('<option value="' + one.id + '"  data-id="' + one.id + '">' + one.name + '</option>');
                        })

                    }
                })
            });
        });


    </script>


@endsection


@section('script')

@endsection
