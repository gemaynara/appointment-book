<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use validate;
use Sentinel;
use DB;
use DataTables;
error_reporting(-1);
ini_set('display_errors', 'On');
use App\Models\Patient;
use App\Models\Doctors;
use App\Models\Setting;
use App\Models\BookAppointment;
use App\Models\Services;
use App\Models\Resetpassword;
use App\Models\FavoriteDoc;
use App\Models\Review;
class UserController extends Controller
{

    public function userpostregister(Request $request){
     //   dd($request->all());
        $getuser=Patient::where("email",$request->get("email"))->first();
        if($getuser){
            Session::flash('message',__("message.Email Already Existe")); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }else{
            $store=new Patient();
            $store->name=$request->get("name");
            $store->email=$request->get("email");
            $store->password=$request->get("password");
            $store->phone=$request->get("phone");
            $store->save();
            if($request->get("rem_me")==1){
                        setcookie('email', $request->get("email"), time() + (86400 * 30), "/");
                        setcookie('password',$request->get("password"), time() + (86400 * 30), "/");
                        setcookie('rem_me',1, time() + (86400 * 30), "/");
            } 
            Session::put("user_id",$store->id);                
            Session::put("role_id",'1');
            return redirect("userdashboard");
        }
    }
    
    public function postloginuser(Request $request){
        $getUser=Patient::where("email",$request->get("email"))->where("password",$request->get("password"))->first();
        if($getUser){
                if($request->get("rem_me")==1){
                        setcookie('email', $request->get("email"), time() + (86400 * 30), "/");
                        setcookie('password',$request->get("password"), time() + (86400 * 30), "/");
                        setcookie('rem_me',1, time() + (86400 * 30), "/");
                } 

                Session::put("user_id",$getUser->id);                
                Session::put("role_id",'1');
                return redirect("userdashboard");
        }else{
            Session::flash('message',__("message.Login Credentials Are Wrong")); 
            Session::flash('alert-class', 'alert-danger');
            return redirect("patientlogin");
        }
    }

    public function userdashboard(Request $request){
       if(Session::get("user_id")!=""&&Session::get("role_id")=='1'){
          $setting=Setting::find(1);
          $type=$request->get("type");
          $bookdata=array();
          $totalappointment=count(BookAppointment::with("doctorls")->where("user_id",Session::get("user_id"))->get());
          $completeappointment=count(BookAppointment::with("doctorls")->where("user_id",Session::get("user_id"))->where("status",4)->get());
          $pendingappointment=count(BookAppointment::with("doctorls")->where("user_id",Session::get("user_id"))->where("status","!=",4)->get());
          if($type==2){ //past
              $bookdata=BookAppointment::with("doctorls")->where("user_id",Session::get("user_id"))->where("date","<",date('Y-m-d'))->paginate(10);
          }elseif($type==3){ //upcoming
              $bookdata=BookAppointment::with("doctorls")->where("user_id",Session::get("user_id"))->where("date",">",date('Y-m-d'))->paginate(10);
          }else{ //today
              $bookdata=BookAppointment::with("doctorls")->where("user_id",Session::get("user_id"))->where("date",date('Y-m-d'))->paginate(10);
          }
          foreach ($bookdata as $b) {
              if(isset($b->doctorls->department_id)){
                  $data=Services::find($b->doctorls->department_id);
                   if($data){
                      $b->department_name=$data->name;
                   }else{
                      $b->department_name="";
                   }
                  
              }else{
                   $b->department_name="";
              }
          }

          $userdata=Patient::find(Session::get("user_id"));
          if(empty($userdata)){
              $this->logout();
          }
          return view("user.patient.dashboard")->with("setting",$setting)->with("bookdata",$bookdata)->with("type",$type)->with("totalappointment",$totalappointment)->with("completeappointment",$completeappointment)->with("pendingappointment",$pendingappointment)->with("userdata",$userdata);
       }else{
          return redirect("/");
       }
       
    }

    public function logout(){
       Session::forget("user_id");
       Session::forget("role_id");
       return redirect("/");
    }

    public function makeappointment(Request $request){
            $this->validate($request, [
                        "date"    => "required",
                        "slot"    => "required",
                        "phone_no"    => "required",
                        "message"  => "required"
                    ]);
                    $slot=explode("#",$request->get("slot"));
                    $getappointment=BookAppointment::where("date",date("Y-m-d",strtotime($request->get("date"))))->where("slot_id",isset($slot[0])?$slot[0]:"")->first();
                          if($getappointment){
                                 Session::flash('message',__('message.Slot Already Booked')); 
                                 Session::flash('alert-class', 'alert-danger');
                                 return redirect()->back();
                          }else{
                                  $data=new BookAppointment();
                                  $data->user_id=Session::get("user_id");
                                  $data->doctor_id=$request->get("doctor_id");
                                  $data->slot_id=isset($slot[0])?$slot[0]:"";
                                  $data->slot_name=isset($slot[1])?$slot[1]:"";
                                  $data->date=date("Y-m-d",strtotime($request->get("date")));
                                  $data->phone=$request->get("phone_no");
                                  $data->user_description=$request->get("message");
                                  $data->save();
                                  Session::flash('message',__('message.Appointment Book Successfully')); 
                                  Session::flash('alert-class', 'alert-success');
                                  return redirect()->back();
                          }  
    }

    public function userfavorite($doc_id){
        if(Session::has("user_id")&&Session::get("role_id")=='1'){
            $getFav=FavoriteDoc::where("doctor_id",$doc_id)->where("user_id",Session::get("user_id"))->first();
            if($getFav){
               $msg=__('message.Doctor remove in Favorite list');
               $op="0";
               $getFav->delete();
            }else{
               $store=new FavoriteDoc();
               $store->doctor_id=$doc_id;
               $store->user_id=Session::get("user_id");
               $store->save();
               $op='1';
               $msg=__('message.Doctor add in Favorite list');
            }  
            $data=array("msg"=>$msg,"class"=>"alert-success","op"=>$op); 
        }else{
            $data=array("msg"=>__('message.Please')." <a href=".url('patientlogin').">".__('message.Login')."</a> ".__('message.Your Account')."","class"=>"alert-danger","op"=>'0'); 
        }

        return json_encode($data);
    }

    public function favouriteuser(){
       if(Session::get("user_id")!=""&&Session::get("role_id")=='1'){
          $setting=Setting::find(1);
          $userdata=Patient::find(Session::get('user_id'));
          $userfavorite=FavoriteDoc::with("doctorls")->where("user_id",Session::get("user_id"))->paginate(9);
          foreach ($userfavorite as $k) {  
                if($k->doctorls){
                    $k->doctorls->avgratting=Review::where('doc_id',$k->doctor_id)->avg('rating');
                    $k->doctorls->totalreview=count(Review::where('doc_id',$k->doctor_id)->get());
                    $k->doctorls->is_fav=1;
                    if(isset($k->doctorls->department_id)&&$k->doctorls->department_id!=""){
                        $getservice=Services::find($k->doctorls->department_id);
                        $k->doctorls->department_name=$getservice->name;
                    }else{
                        $k->doctorls->department_name="";
                    }
                           
                }
          }   
          return view("user.patient.favourite")->with("userdata",$userdata)->with("setting",$setting)->with("userfavorite",$userfavorite);
       }
       else{
          return redirect('/');
       }
    }

    public function viewschedule(){
       if(Session::get("user_id")!=""&&Session::get("role_id")=='1'){
          $setting=Setting::find(1);
          $userdata=Patient::find(Session::get('user_id'));          
          return view("user.patient.scheduleappointment")->with("userdata",$userdata)->with("setting",$setting);
       }
       else{
          return redirect('/');
       }
    }

    public function changepassword(){
      if(Session::get("user_id")!=""&&Session::get("role_id")=='1'){
        $setting=Setting::find(1);
        $userdata=Patient::find(Session::get("user_id"));
        return view("user.patient.changepassword")->with("userdata",$userdata)->with("setting",$setting);
      }else{
         return redirect('/');
      }
    }

    public function checkuserpwd(Request $request){
        $data=Patient::find(Session::get("user_id"));
        if($data){
            if($data->password==$request->get("cpwd")){
                return 1;
            }else{
                return 0;
            }
        }else{
           return redirect("/");
        }
    }

    public function updateuserpassword(Request $request){
          $data=Patient::find(Session::get("user_id"));
          $data->password=$request->get("npwd");
          $data->save();
          Session::flash('message',__('message.Password Change Successfully')); 
          Session::flash('alert-class', 'alert-success');
          return redirect()->back();
    }

    public function userreview(){
      if(Session::get("user_id")!=""&&Session::get("role_id")=='1'){
          $setting=Setting::find(1);
          $userdata=Patient::find(Session::get("user_id"));
          $datareview=Review::with("doctorls")->where("user_id",Session::get("user_id"))->orderby("id","DESC")->get();
          foreach ($datareview as $k) {
             $ddp=Services::find($k->doctorls->department_id);
             if($ddp){
                $k->doctorls->department_name=$ddp->name;
             }else{
                $k->doctorls->department_name="";
             }
          }
          return view("user.patient.review")->with("setting",$setting)->with("userdata",$userdata)->with("datareview",$datareview);
      }else{
          return redirect("/");
      }
    }

    public function usereditprofile(){
        if(Session::get("user_id")!=""&&Session::get("role_id")=='1'){
          $setting=Setting::find(1);
          $userdata=Patient::find(Session::get("user_id"));
          return view("user.patient.editprofile")->with("setting",$setting)->with("userdata",$userdata);
        }else{
          return redirect("/");
        }
    }

    public function updateuserprofile(Request $request){
      $user=Patient::find(Session::get("user_id"));
      $findemail=Patient::where("email",$request->get("email"))->where("id","!=",Session::get("user_id"))->first();
      if($findemail){
           Session::flash('message',__('message.Email Id Already Use By Other User')); 
           Session::flash('alert-class', 'alert-danger');
           return redirect()->back();
      }else{

           $img=$user->profile_pic;
           $rel_url=$user->profile_pic;
           if ($request->hasFile('image')) 
              {
                  $file = $request->file('image');
                  $filename = $file->getClientOriginalName();
                  $extension = $file->getClientOriginalExtension() ?: 'png';
                  $folderName = '/upload/profile/';
                  $picture = time() . '.' . $extension;
                  $destinationPath = public_path() . $folderName;
                  $request->file('image')->move($destinationPath, $picture);
                  $img =$picture;                
                  $image_path = public_path() ."/upload/profile/".$rel_url;
                  if(file_exists($image_path)&&$rel_url!="") {
                      try {
                            unlink($image_path);
                      }catch(Exception $e) {
                                                  
                      }                        
                  }
            }
           $user->name=$request->get("name");
           $user->email=$request->get("email");
           $user->phone=$request->get("phone");
           $user->profile_pic=$img;
           $user->save();
           Session::flash('message',__('message.Password Change Successfully')); 
           Session::flash('alert-class', 'alert-success');
           return redirect()->back();
      }
      //dd($request->all());
    }
    
    
      public function resetpassword($code){
            $setting = Setting::find(1);
            $data=Resetpassword::where("code",$code)->first();
            if($data){
              return view('user.resetpwd')->with("id",$data->user_id)->with("code",$code)->with("type",$data->type)->with("setting",$setting);
            }else{
              return view('user.resetpwd')->with("msg",__('message.Code Expired'))->with("setting",$setting);
            }
      }
      public function resetnewpwd(Request $request){
           $setting = Setting::find(1);
            if($request->get('id')==""){
                return view('user.resetpwd')->with("msg",__('message.pwd_reset'))->with("setting",$setting);
            }else{
                if($request->get("type")==1){
                     $user=Patient::find($request->get('id'));
                }else{
                    $user=Doctors::find($request->get('id'));
                }
                $user->password=$request->get('npwd');
                $user->save();
                $codedel=Resetpassword::where('user_id',$request->get("id"))->delete();
                return view('user.resetpwd')->with("msg",__('message.pwd_reset'))->with("setting",$setting);
            }
      }

}
