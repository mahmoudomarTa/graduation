@extends('admin.users.sideMenu')
@section('companyContent')
	<div class="flex-row-fluid ml-lg-8">
            <div class="card card-custom gutter-b example example-compact">

                         <div class="card-header">
                                <h3 class="card-title">{{__('cp.edit_personal_info')}}</h3>
                            </div>

                    <form method="post" action="{{url(app()->getLocale().'/admin/users/'.$item->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                        {{ csrf_field() }}
                           {{ method_field('PATCH')}}


                       <div class="row col-sm-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.name')}}</label>
                                    <input type="text" class="form-control form-control-solid"
                                            name="name" value="{{$item->name}}" required/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.email')}}</label>
                                    <input type="text" class="form-control form-control-solid" name="email"
                                        value="{{$item->email}}"    required/>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('cp.mobile')}}</label>
                                    <input type="text" class="form-control form-control-solid" name="mobile" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                        value="{{$item->mobile}}"   required/>
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




                               <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{url(getLocal().'/admin/users')}}" class="btn btn-secondary  mr-2">{{__('cp.cancel')}}</a>
                    <button id="submitButton" class="btn btn-success ">{{__('cp.save')}}</button>
                </div>
                <!--end::Toolbar-->
                        <button type="submit" id="submitForm" style="display:none"></button>
                    </form>

      </div>
      </div>
@endsection
@section('js')

<script>
        $(document).on('click', '#submitButton', function(){
            $('#submitForm').click();
        });
</script>
@endsection
