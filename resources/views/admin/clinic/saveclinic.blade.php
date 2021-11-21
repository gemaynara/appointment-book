@extends('admin.layout')
@section('title')
    {{__("message.save")}} {{__("message.Clinics")}} | {{__("message.Admin")}} {{__("message.Clinics")}}
@stop
@section('meta-data')
@stop
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0">{{__("message.save")}} {{__("message.Clinic")}}</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a
                                            href="{{url('admin/clinics')}}">{{__("message.Clinics")}}</a></li>
                                    <li class="breadcrumb-item active">{{__("message.save")}} {{__("message.Clinic")}}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: flex;justify-content: center;">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{url('admin/updateclinic')}}" class="needs-validation" method="post"
                                      enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" id="doctor_id" value="{{$id}}">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="mar20">
                                                    <div id="uploaded_image">
                                                        <div class="upload-btn-wrapper">
                                                            <button type="button" class="btn imgcatlog">
                                                                <input type="hidden" name="real_basic_img"
                                                                       id="real_basic_img"
                                                                       value="<?= isset($data->image) ? $data->image : ""?>"/>
                                                                <?php
                                                                if (isset($data->image)) {
                                                                    $path = asset('upload/clinics/'. $data->image) ;
                                                                } else {
                                                                    $path = asset('upload/profile/profile.png');
                                                                }
                                                                ?>
                                                                <img src="{{$path}}" alt="..."
                                                                     class="img-thumbnail imgsize" id="basic_img">
                                                            </button>
                                                            <input type="hidden" name="basic_img" id="basic_img1"/>
                                                            <input type="file" name="upload_image" id="upload_image"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">{{__("message.Name")}}<span class="reqfield">*</span></label>
                                                <input type="text" class="form-control"
                                                       placeholder='{{__("message.Enter Clinic Name")}}' id="name"
                                                       name="name" required=""
                                                       value="{{isset($data->name)?$data->name:''}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">{{__("message.Corporate Name")}}<span
                                                        class="reqfield">*</span></label>
                                                <input type="text" class="form-control" id="corporate_name"
                                                       placeholder='{{__("message.Enter Corporate Name")}}'
                                                       name="corporate_name" required=""
                                                       value="{{isset($data->corporate_name)?$data->corporate_name:''}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="department_id">{{__("message.Services")}}<span
                                                        class="reqfield">*</span></label>
                                                <select class="select-services form-control" name="services[]"
                                                        id="services" required="" multiple="multiple">
                                                    <?php $service = isset($data->services) ? explode(",", ($data->services)) : []?>
                                                    @foreach($services as $key=>$value)
                                                        <option
                                                            @foreach($service as $s)
                                                            @if($s== $key) selected
                                                            @endif
                                                            @endforeach
                                                            value="{{$key}}">{{$value}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="email">{{__("message.Cnpj")}}<span class="reqfield">*</span></label>
                                                <input type="text" class="form-control cnpj" id="cnpj" maxlength="18"
                                                       placeholder='{{__("message.Enter Cnpj")}}' name="cnpj"
                                                       required="" value="{{isset($data->cnpj)?$data->cnpj:''}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="phoneno">{{__("message.Phone")}}<span
                                                        class="reqfield">*</span></label>
                                                <input type="text" class="form-control phone" id="phoneno"
                                                       maxlength="14"
                                                       placeholder='{{__("message.Enter Phone")}}' name="phone"
                                                       required="" value="{{isset($data->phone)?$data->phone:''}}">
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="email">{{__("message.Email")}}<span
                                                        class="reqfield">*</span></label>
                                                <input type="email" class="form-control" id="email"
                                                       placeholder='{{__("message.Enter Email Address")}}' name="email"
                                                       required=""
                                                       <?= isset($id) && $id != 0 ? 'readonly' : ""?> value="{{isset($data->email)?$data->email:''}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="email">{{__("message.Contact Person")}}<span
                                                        class="reqfield">*</span></label>
                                                <input type="text" class="form-control" id="contact_person"
                                                       placeholder='{{__("message.Enter Contact Person")}}'
                                                       name="contact_person"
                                                       required=""
                                                       value="{{isset($data->contact_person)?$data->contact_person:''}}">
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">{{__("message.Agency")}}<span
                                                        class="reqfield">*</span></label>
                                                <input type="text" class="form-control agency" id="agency" maxlength="6"
                                                       placeholder='{{__("message.Enter Agency")}}' name="agency"
                                                       required="" value="{{isset($data->agency)?$data->agency:''}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="services">{{__("message.Account")}}<span
                                                        class="reqfield">*</span></label>
                                                <input type="text" class="form-control account" id="account"
                                                       maxlength="20"
                                                       placeholder='{{__("message.Enter Account")}}'
                                                       name="account" required=""
                                                       value="{{isset($data->account)?$data->account:''}}"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">{{__("message.License File")}}<span
                                                        class="reqfield">*</span></label>
                                                @if(isset($data->license_file))
                                                    <a href="{{url('admin/viewlicense/'.$data->license_file)}}"
                                                       target="_blank"
                                                       class="badge-secondary small ml-2">{{__("message.View File")}}
                                                        - {{$data->license_file}}</a>
                                                @endif

                                                <input type="file" class="form-control" id="license_file"
                                                       name="license_file" {{!isset($data->license_file) ? 'required': ''}}>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">{{__("message.License Expired At")}}<span
                                                        class="reqfield">*</span></label>
                                                <input type="date" class="form-control" id="license_expired_at"
                                                       name="license_expired_at"
                                                       value="{{isset($data->license_expired_at)?$data->license_expired_at:''}}"
                                                       required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">{{__("message.License Health File")}}<span
                                                        class="reqfield">*</span></label>
                                                @if(isset($data->license_health_file))
                                                    <a href="{{url('admin/viewlicense/'.$data->license_health_file)}}"
                                                       target="_blank"
                                                       class="badge-secondary small ml-2">{{__("message.View File")}}
                                                        - {{$data->license_health_file}}</a>
                                                @endif
                                                <input type="file" class="form-control" id="license_health_file"
                                                       name="license_health_file"
                                                    {{!isset($data->license_health_file) ? 'required': ''}}>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">{{__("message.License Health Expired At")}}<span
                                                        class="reqfield">*</span></label>
                                                <input type="date" class="form-control" id="license_health_expired_at"
                                                       name="license_health_expired_at"
                                                       value="{{isset($data->license_health_expired_at)?$data->license_health_expired_at:''}}"
                                                       required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit"
                                                    value="Submit">{{__("message.Submit")}}</button>


                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer')
@stop
