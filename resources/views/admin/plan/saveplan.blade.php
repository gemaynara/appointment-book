@extends('admin.layout')
@section('title')
    {{__("message.Add Plan")}} | {{__("message.Admin")}}
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
                            <h4 class="mb-0">{{__("message.Add Plan")}}</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{url('admin/plans')}}">{{__("message.Plans")}}</a></li>
                                    <li class="breadcrumb-item active">{{__("message.Add Plan")}}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: flex;justify-content: center;">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{url('admin/updateplan')}}" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{$id}}">
                                    <div class="form-group">
                                        <label for="formrow-firstname-input">{{__("message.Name")}}</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder='{{__("message.Enter Health Plan Name")}}' value="{{isset($data)?$data->name:''}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="formrow-firstname-input">{{__("message.Image")}}</label>
                                        @if($data)
                                            <img src="{{asset('public/upload/plans').'/'.$data->image}}" style="width: 150px;height: 150px" />
                                            <input type="file" class="form-control" id="image" name="image" >
                                        @else
                                            <input type="file" class="form-control" required="" id="image" name="image" >
                                        @endif
                                    </div>
                                    <div class="mt-4">
                                            <button  class="btn btn-primary" type="submit" value="Submit">{{__("message.Submit")}}</button>
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
