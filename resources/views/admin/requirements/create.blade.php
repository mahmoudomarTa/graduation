@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.requirements'))}}
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
                        <h3>{{__('cp.add_requirement')}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{url(getLocal().'/admin/requirements')}}" class="btn btn-secondary  mr-2">{{__('cp.cancel')}}</a>
                    <button id="submitButton" class="btn btn-success ">{{__('cp.save')}}</button>
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
                    <form method="post" action="{{url(app()->getLocale().'/admin/requirements')}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                        {{ csrf_field() }}

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
                                                   name="name" value="{{old('name')}}" required />
                                        </div>
                                    </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('cp.status')}}</label>
                                        <select   class="form-control form-control-solid"
                                                  name="status" required>
                                            <option
                                                value="active">
                                                {{__('cp.active')}}
                                            </option>
                                            <option
                                                value="not_active">
                                                {{__('cp.not_active')}}
                                            </option>
                                        </select>
                                    </div>
                                </div>

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
                    url: "{{ url(getLocal().'/admin/getYears') }}",
                    type: "get",
                    data: {
                        id: id,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('#year_id').empty();
                        $('#year_id').attr("disabled", false);
                        $('#year_id').append('<option value="">' + "@lang('cp.choose')" + '</option>');
                        $.each(data.items, function (index, one) {
                            $('#year_id').append('<option value="' + one.year.id + '"  data-id="' + one.year.id + '">' + one.year.name + '</option>');
                        })

                    }
                })
            });
        });
    </script>

@endsection

@section('script')

@endsection
