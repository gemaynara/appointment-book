@extends('admin.layout')
@section('title')
    {{__("message.Type Service")}} | {{__("message.Admin")}}
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
                            <h4 class="mb-0">{{__("message.Add Type Service")}}</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a
                                            href="{{url('admin/services')}}">{{__("message.Type Service")}}</a></li>
                                    <li class="breadcrumb-item active">{{__("message.Add Type Service")}}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: flex;justify-content: center;">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{url('admin/updatetypeservice')}}" method="post"
                                      enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{$id}}">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>{{__("message.Name")}}</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                       placeholder='{{__("message.Enter Type Service Name")}}'
                                                       value="{{isset($data)?$data->name:''}}" required>
                                            </div>

                                            <div class="form-group">
                                                <label>{{__("message.Description")}}</label>
                                                <textarea id="description" class="form-control" rows="5" name="description"
                                                          placeholder='{{__("message.Enter Description")}}'
                                                          required="">{{isset($data->description)?$data->description:''}}</textarea>

                                            </div>

                                            <div class="form-group">
                                                <label
                                                    for="verti-nav-phoneno-input">{{__("message.Type Service")}}</label>
                                                <select class="form-control type" name="type" id="type" required>
                                                    <option value="">{{__("message.select")}}</option>
                                                    @foreach($types as $key=>$value)
                                                        <option
                                                            value="{{$key}}" {{isset($data->type) == $key? 'selected': ''}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{__("message.Price")}}</label>
                                                <input type="text" required name="price"
                                                       value="{{isset($data->price)?$data->price:null}}"
                                                       placeholder='{{__("message.Enter Price")}}'
                                                       class="form-control number">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{__("message.Displacement Rate")}}</label>
                                                <input type="text" required name="displacement_rate"
                                                       placeholder='{{__("message.Enter Displacement Rate")}}'
                                                       value="{{isset($data->displacement_rate)?$data->displacement_rate:null}}"
                                                       class="form-control number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group producer-div" style="display: none">
                                        <label>{{__("message.Producer")}}</label>
                                        <input type="text" class="form-control" id="producer" name="producer"
                                               placeholder='{{__("message.Enter Producer Name")}}'
                                               value="{{isset($data)?$data->producer:''}}">
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-primary" type="submit"
                                                value="Submit">{{__("message.Submit")}}</button>

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
