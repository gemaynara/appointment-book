<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Session;
use validate;
use Sentinel;
use DB;
use App\Models\Doctors;
use App\Models\BookAppointment;
use App\Models\Patient;
use DataTables;
class AppointmentController extends Controller
{
    
    public function showappointment(){
         return view("admin.appointment.default");
    }
   
    public function appointmenttable(){
          $book =BookAppointment::with('doctorls','patientls')->get();
           return DataTables::of($book)
            ->editColumn('id', function ($book) {
                return $book->id;
            })
            ->editColumn('doctor_name', function ($book) {
                return isset($book->doctorls)?$book->doctorls->name:"";
            })
            ->editColumn('patient_name', function ($book) {
                return isset($book->patientls)?$book->patientls->name:"";
            })  
            ->editColumn('date', function ($book) {
                return $book->date." ".$book->slot_name;
            })  
            ->editColumn('phone', function ($book) {
                return $book->phone;
            })  
            ->editColumn('u_desc', function ($book) {

                return isset($book->user_description)?$book->user_description:"";
            })  
            ->editColumn('status', function ($book) {
                if($book->status=='1'){
                     return __("message.Received");
                }else if($book->status=='2'){
                     return __("message.Approved");
                }else if($book->status=='3'){
                     return __("message.In Process");
                }
                else if($book->status=='4'){
                     return __("message.Completed");
                }
                else if($book->status=='5'){
                     return __("message.Rejected");
                }else{
                     return __("message.Absent");
                }
            }) 
           
            ->make(true);
    }

    public function latsrappointmenttable(){
       $book =BookAppointment::with('doctorls','patientls')->where("date",date("Y-m-d"))->get();
           return DataTables::of($book)
            ->editColumn('id', function ($book) {
                return $book->id;
            })
            ->editColumn('doctor_name', function ($book) {
                return isset($book->doctorls)?$book->doctorls->name:"";
            })
            ->editColumn('patient_name', function ($book) {
                return isset($book->patientls)?$book->patientls->name:"";
            })  
            ->editColumn('date', function ($book) {
                return $book->date." ".$book->slot_name;
            })  
            ->editColumn('phone', function ($book) {
                return $book->phone;
            })  
            ->editColumn('u_desc', function ($book) {

                return isset($book->user_description)?$book->user_description:"";
            })  
            ->editColumn('status', function ($book) {
                if($book->status=='1'){
                     return __("message.Received");
                }else if($book->status=='2'){
                     return __("message.Approved");
                }else if($book->status=='3'){
                     return __("message.In Process");
                }
                else if($book->status=='4'){
                     return __("message.Completed");
                }
                else if($book->status=='5'){
                     return __("message.Rejected");
                }else{
                     return __("message.Absent");
                }
            }) 
           
            ->make(true);
    }

    public function changeappstatus($id,$status){
        $data=BookAppointment::find($id);
        $data->status=$status;
        $data->save();
        if($status==3){//in process
            $msg=__("message.Appointment In Process");
        }elseif($status==4){//complete
            $msg=__("message.Appointment In Complete");
        }else{//reject
            $msg=__("message.Appointment In Reject");
        }
        Session::flash('message',$msg); 
        Session::flash('alert-class', 'alert-success');
        return redirect("admin/appointment");
    }

     public function notification($act){
      $data=array();
      if($act==1){
         $result=$this->haveOrdersNotification();
           $orderdata=$this->haveOrdersdata();
            if(isset($result)){
               $data = array(
                      "status" => http_response_code(),
                      "request" => "success",
                      "response" => array(
                      "message" => __("message.Request Completed Successfully"),
                      "total" => $result,
                      "orderdata"=>$orderdata
               )
             );
           }
           $updatenotify=$this->updatenotify();

      }
      else{
           $result=$this->haveOrdersNotification();
           $orderdata=$this->haveOrdersdata();
            if(isset($result)){
               $data = array(
                      "status" => http_response_code(),
                      "request" => "success",
                      "response" => array(
                      "message" => __("message.Request Completed Successfully"),
                      "total" => $result,
                      "orderdata"=>$orderdata
               )
             );
           }
       }
       return $data;
     }

     public function haveOrdersNotification(){
        $order=BookAppointment::where("notify",'1')->get();
        return count($order);
     }
      public function haveOrdersdata(){
        $order=BookAppointment::where("notify",'1')->get();
        return count($order);
     }

     public function updatenotify(){
      $order=BookAppointment::where("notify",'1')->get();
      foreach ($order as $k) {
         $k->notify='0';
         $k->save();
      }
      return "done";
     }
}
