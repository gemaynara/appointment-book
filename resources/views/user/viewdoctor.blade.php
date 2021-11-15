@extends('user.layout')
@section('title')
{{__('message.Doctor Details')}}
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{$data->name}}"/>
<meta property="og:title" content="{{$data->name}}"/>
<meta property="og:image" content="{{asset('public/upload/doctors').'/'.$data->image}}"/>
<meta property="og:image:width" content="250px"/>
<meta property="og:image:height" content="250px"/>
<meta property="og:site_name" content="{{$data->name}}"/>
<meta property="og:description" content="{{__('message.meta_description')}}"/>
<meta property="og:keyword" content="{{__('message.Meta Keyword')}}"/>
<link rel="shortcut icon" href="{{asset('public/image_web/').'/'.$setting->favicon}}">
<meta name="viewport" content="width=device-width, initial-scale=1">
@stop
@section('content')
<section class="page-title-two">
   <div class="title-box centred bg-color-2">
      <div class="pattern-layer">
         <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-70.png')}}');"></div>
         <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-71.png')}}');"></div>
      </div>
      <div class="auto-container">
         <div class="title">
            <h1>{{__('message.Doctor Details')}}</h1>
         </div>
      </div>
   </div>
   <div class="lower-content">
      <div class="auto-container">
         <ul class="bread-crumb clearfix">
            <li><a href="{{url('/')}}">{{__('message.Home')}}</a></li>
            <li>{{__('message.Doctor Details')}}</li>
         </ul>
      </div>
   </div>
</section>
@if(empty($data))
{{__('message.Result Not Found')}}
@else
<section class="doctor-details bg-color-3">
   <div class="auto-container">
      <div class="row clearfix">
         <div class="col-lg-8 col-md-12 col-sm-12 content-side">
            <div class="clinic-details-content doctor-details-content">
               <div class="clinic-block-one">
                  <div class="inner-box">
                     <figure class="image-box">
                        <?php 
                              if($data->image==""){
                                  $path=asset('public/upload/doctors/default.png');
                              }else{
                                  $path=asset('public/upload/doctors').'/'.$data->image;
                              }
                        
                        ?>
                        <div class="doctor-detail-page-main-box" style="background-image:url('{{$path}}')"></div>
                     </figure>
                     <div class="content-box">
                        @if($data->is_fav=='0')
                        @if(empty(Session::has("user_id")))
                        <a href="{{url('patientlogin')}}" id="favdoc{{$dl->id}}">
                        @else
                        <a href="javascript:userfavorite('{{$data->id}}')" id="favdoc{{$data->id}}">
                        @endif
                        @else
                        <a href="javascript:userfavorite('{{$data->id}}')" class="activefav" id="favdoc{{$data->id}}">
                           @endif
                        </a>
                         
                           <div class="like-box">
                              <a href="#">
                                 <i class="far fa-heart"></i>
                              </a>
                           </div>
                           <div class="middle body">
                              <div class="sm-container">
                                 <i class="show-btn fas fa-share-alt"></i>
                                 <div class="sm-menu">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{url('viewdoctor').'/'.$data->id}}"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://web.whatsapp.com/send?url={{url('viewdoctor').'/'.$data->id}}"><i class="fab fa-whatsapp"></i></a>
                                    <a href="https://twitter.com/intent/tweet?text={{$data->name}}&url={{url('viewdoctor').'/'.$data->id}}"><i class="fab fa-twitter"></i></a>
                                 </div>
                              </div>
                           </div>

                        <ul class="name-box clearfix">
                           <li class="name">
                              <h2>{{$data->name}}</h2>
                           </li>
                           
                        </ul>
                        <span class="designation">{{$data->departmentls->name}}</span>
                        <div class="rating-box clearfix">
                           <ul class="rating clearfix">
                              <?php
                                 $arr = $data->avgratting;
                                 if (!empty($arr)) {
                                   $i = 0;
                                   if (isset($arr)) {
                                       for ($i = 0; $i < $arr; $i++) {
                                           echo '<li><i class="icon-Star"></i></li>';
                                       }
                                   }
                                   
                                       $remaing = 5 - $i;
                                       for ($j = 0; $j < $remaing; $j++) {
                                           echo '<li class="light" style="color:gray !important"><i class="icon-Star"></i></li>';
                                       }
                                  
                                 }else{

                                    for ($j = 0; $j <5; $j++) {
                                           echo '<li class="light" style="color:gray !important"><i class="icon-Star"></i></li>';
                                       }
                                 }?>
                              <li><a href="#">({{$data->totalreview}})</a></li>
                           </ul>
                        </div>
                        <div class="text">
                           <p>{{substr($data->aboutus,0,75)}}</p>
                        </div>
                        <div class="lower-box clearfix">
                           <ul class="info clearfix">
                              <li><i class="fas fa-map-marker-alt"></i>{{substr($data->address,0,40)}}</li>
                              <li><i class="fas fa-phone"></i><a href="{{$data->phoneno}}">{{$data->phoneno}}</a></li>
                           </ul>
                           <div class="view-map"><a href="https://maps.google.com/?q={{$data->lat}},{{$data->lon}}" target="_blank">{{__('message.View Map')}}</a></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="tabs-box">
                  <div class="tab-btn-box centred">
                     <ul class="tab-btns tab-buttons clearfix">
                        <li class="tab-btn active-btn" data-tab="#tab-1">{{__('message.About Us')}}</li>
                        <li class="tab-btn" data-tab="#tab-2">{{__('message.Services')}}</li>
                        <li class="tab-btn" data-tab="#tab-3">{{__('message.Health Care')}}</li>
                        <li class="tab-btn" data-tab="#tab-4">{{__('message.Review')}}</li>
                     </ul>
                  </div>
                  <div class="tabs-content">
                     <div class="tab active-tab" id="tab-1">
                        <div class="inner-box">
                           <div class="text">
                              <h3>{{__('message.About')}} {{$data->name}}:</h3>
                              <p>{{$data->aboutus}}</p>
                           </div>
                        </div>
                     </div>
                     <div class="tab" id="tab-2">
                        <div class="experience-box">
                           <div class="text">
                              <h3>{{__('message.Services')}}</h3>
                              <p>{{$data->services}}</p>
                           </div>
                        </div>
                     </div>
                     <div class="tab" id="tab-3">
                        <div class="location-box">
                           <h3>{{__('message.Health Care')}}</h3>
                           {{$data->healthcare}}
                        </div>
                     </div>
                     <div class="tab" id="tab-4">
                        <div class="review-box">
                           <h3>{{$data->name}} {{__('message.Review')}}</h3>
                           <div class="rating-inner">
                              <div class="rating-box">
                                 <h2>{{isset($data->avgratting)?$data->avgratting:0}}</h2>
                                 <ul class="clearfix">
                                    <?php
                                       $arr = $data->avgratting;
                                       if (!empty($arr)) {
                                         $i = 0;
                                         if (isset($arr)) {
                                             for ($i = 0; $i < $arr; $i++) {
                                                 echo '<li><i class="icon-Star"></i></li>';
                                             }
                                         }
                                         
                                             $remaing = 5 - $i;
                                             for ($j = 0; $j < $remaing; $j++) {
                                                 echo '<li class="light" style="color:gray !important"><i class="icon-Star"></i></li>';
                                             }
                                        
                                       }else{
                                          for ($j = 0; $j <5; $j++) {
                                                 echo '<li class="light" style="color:gray !important"><i class="icon-Star"></i></li>';
                                             }
                                       }?>
                                 </ul>
                                 <span>{{__('message.Based on 5 review')}}</span>
                              </div>
                              <div class="rating-pregress">
                                 <div class="single-progress">
                                     <?php $star5=  isset($data->startrattinglines['start5'])?$data->startrattinglines['start5']:"0";
                                           $star4=  isset($data->startrattinglines['start4'])?$data->startrattinglines['start4']:"0";
                                           $star3=  isset($data->startrattinglines['start3'])?$data->startrattinglines['start3']:"0";
                                           $star2=  isset($data->startrattinglines['start2'])?$data->startrattinglines['start2']:"0";
                                           $star1=  isset($data->startrattinglines['start1'])?$data->startrattinglines['start1']:"0";
                                      ?>
                                     <style type="text/css">
                                          .doctor-details-content .tabs-box .tabs-content .review-box .rating-inner .  rating-pregress .single-progress:first-child .porgress-bar:before {
                                                width: {{$star5}}%;
                                           }
                                            .doctor-details-content .tabs-box .tabs-content .review-box .rating-inner .rating-pregress .single-progress:nth-child(2) .porgress-bar:before {
                                                width: {{$star4}}%;
                                           }
                                            .doctor-details-content .tabs-box .tabs-content .review-box .rating-inner .rating-pregress .single-progress:nth-child(3) .porgress-bar:before {
                                                width: {{$star3}}%;
                                           }
                                            .doctor-details-content .tabs-box .tabs-content .review-box .rating-inner .rating-pregress .single-progress:nth-child(4) .porgress-bar:before {
                                                width: {{$star2}}%;
                                           }
                                           .doctor-details-content .tabs-box .tabs-content .review-box .rating-inner .rating-pregress .single-progress:nth-child(5) .porgress-bar:before {
                                                width: {{$star1}}%;
                                           }
                                        </style>
                                    <span class="porgress-bar"></span>
                                    <div class="text">
                                       <p><i class="icon-Star"></i> {{__('message.5 Stars')}}</p>
                                    </div>
                                 </div>
                                 <div class="single-progress">
                                    <span class="porgress-bar"></span>
                                    <div class="text">
                                       <p><i class="icon-Star"></i>{{__('message.4 Stars')}}</p>
                                    </div>
                                 </div>
                                 <div class="single-progress">
                                    <span class="porgress-bar"></span>
                                    <div class="text">
                                       <p><i class="icon-Star"></i>{{__('message.3 Stars')}}</p>
                                    </div>
                                 </div>
                                 <div class="single-progress">
                                    <span class="porgress-bar"></span>
                                    <div class="text">
                                       <p><i class="icon-Star"></i>{{__('message.2 Stars')}}</p>
                                    </div>
                                 </div>
                                 <div class="single-progress">
                                    <span class="porgress-bar"></span>
                                    <div class="text">
                                       <p><i class="icon-Star"></i>{{__('message.1 Stars')}}</p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="review-inner">
                              @foreach($data->reviewslist as $dr)
                              <div class="single-review-box">
                                 <figure class="image-box"><img src="{{asset('public/upload/profile/profile.png')}}" alt=""></figure>
                                 <ul class="rating clearfix">
                                    <?php
                                       $arr = $dr->rating;
                                       if (!empty($arr)) {
                                         $i = 0;
                                         if (isset($arr)) {
                                             for ($i = 0; $i < $arr; $i++) {
                                                 echo '<li><i class="icon-Star"></i></li>';
                                             }
                                         }
                                         
                                             $remaing = 5 - $i;
                                             for ($j = 0; $j < $remaing; $j++) {
                                                 echo '<li class="light"><i class="icon-Star"></i></li>';
                                             }
                                        
                                       }else{
                                          for ($j = 0; $j <5; $j++) {
                                                 echo '<li class="light"><i class="icon-Star"></i></li>';
                                             }
                                       }?>                       
                                 </ul>
                                 <h6>{{$dr->patientls->name}}<span>- 
                                    <?php 
                                       ?>{{date("F d, Y",strtotime($dr->created_at))}}</span>
                                 </h6>
                                 <p>{{$dr->description}}</p>
                              </div>
                              @endforeach
                           </div>
                           <div class="btn-box">
                              <a href="doctors-details.html" class="theme-btn-one">{{__('message.Submit Review')}}<i class="icon-Arrow-Right"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
            <div class="doctors-sidebar">
               <div class="form-widget">
                  <div class="form-title">
                     <h3>{{__('message.Book Appointment')}}</h3>
                     <p>{{__('message.Monday to Sunday')}}: {{$data->working_time}}</p>
                  </div>
                  <form action="{{url('makeappointment')}}" method="post">
                     {{csrf_field()}}
                     <div class="form-inner">
                        <div class="appointment-time">
                          
                           @if(Session::has('message'))
                           <div class="col-sm-12">
                              <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">
                                 {{ Session::get('message') }}
                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                           </div>
                           @endif
                           @if ($errors->any())
                           <div class="alert alert-danger">
                              <ul>
                                 @foreach ($errors->all() as $error)
                                 <li>{{ $error }}</li>
                                 @endforeach
                              </ul>
                           </div>
                           @endif
                           <input type="hidden" name="doctor_id" id="doctor_id" value="{{$data->id}}">
                           <div class="form-group">
                              <input type="text" name="date"  value="{{date('m/d/Y')}}" id="datepicker" onchange="slotdivchange(this.value)">
                              <i class="fas fa-calendar-alt"></i>
                           </div>
                           @if(!empty($schedule))
                           <div class="custom-dropdown" id="timerange" style="    width: 100%;margin-bottom: 10px;" >
                              <select class="" name="slottime" id="slottime" required="" onchange="slotchange(this.value)">
                                 @foreach($schedule as $s)
                                 <option value="{{$s['id']}}" data-display-text="Fruits">{{$s['title']}}</option>
                                 @endforeach
                              </select>
                           </div>
                           @endif
                           <div class="custom-slot-design-box">
                              <ul id="slotdiv">
                                 @if(!empty($schedule))
                                     @foreach($schedule as $s)
                                         @foreach($s['slottime'] as $ns)
                                           <li>
                                              @if($ns['is_book']==0)
                                              <input type='radio' value='{{$ns["id"]."#".$ns["name"]}}' name='slot' id='{{$ns["id"]}}'/>
                                              <label for='{{$ns["id"]}}'>{{$ns["name"]}}</label>
                                              @else
                                              <input type='radio' value='{{$ns["id"]."#".$ns["name"]}}' name='slot' id='{{$ns["id"]}}' disabled/>
                                              <label class="custom-radio-disabled" for='radio4'>{{$ns["name"]}}</label>
                                              @endif
                                           </li>
                                          @endforeach
                                          @break;
                                     @endforeach
                                 @endif
                              </ul>
                           </div>
                        </div>
                        <div class="choose-service">
                           <h4>{{__('message.Enter Information')}}</h4>
                           <div class="form-group">
                              <label>{{__('message.Phone no')}}</label>
                              <input type="text" name="phone_no" placeholder="{{__('message.Enter Your Phone number')}}" required="">
                           </div>
                           <div class="form-group">
                              <label>{{__('message.Message')}}</label>
                              <textarea id="message" rows="15" name="message" placeholder="{{__('message.Enter Your Message')}}">
                              </textarea>
                           </div>
                           <div class="btn-box" id="btnappointment">
                              @if(Session::has("user_id"))
                                  <button class="theme-btn-one" type="submit">{{__('message.Book Appointment')}}<i class="icon-Arrow-Right"></i></button>
                              @else
                                <button type="button" class="theme-btn-one" onclick="pleaselogin()">{{__('message.Book Appointment')}}<i class="icon-Arrow-Right"></i></button>

                              @endif
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endif
@stop
@section('footer')

   <script type="text/javascript">
      document.querySelector('.show-btn').addEventListener('click', function() {
        document.querySelector('.sm-menu').classList.toggle('active');
      });
   </script>

@stop