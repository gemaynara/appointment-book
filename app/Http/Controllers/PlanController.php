<?php

namespace App\Http\Controllers;

use Session;
use DataTables;
use App\Models\Plans;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function showplans()
    {
        return view("admin.plan.default");
    }

    public function planstable()
    {
        $plans = Plans::all();

        return DataTables::of($plans)
            ->editColumn('id', function ($plans) {
                return $plans->id;
            })
            ->editColumn('image', function ($plans) {
                return asset("upload/plans/". $plans->image);
            })
            ->editColumn('name', function ($plans) {
                return $plans->name;
            })
//            ->editColumn('active', function ($plans) {
//                return ($plans->active) ? "Enabled" : "Disabled";
//            })
            ->editColumn('action', function ($plans) {
                $edit= url('admin/saveplan',array('id'=>$plans->id));
                $delete= url('admin/deleteplan',array('id'=>$plans->id));
                $return = '<a  rel="tooltip" title="" href="'.$edit.'" class="m-b-10 m-l-5" data-original-title="Remove"><i class="fa fa-edit f-s-25" style="margin-right: 10px;"></i></a><a onclick="delete_record(' . "'" . $delete . "'" . ')" rel="tooltip" title="" class="m-b-10 m-l-5" data-original-title="Remove"><i class="fa fa-trash f-s-25"></i></a>';
                return $return;
            })
            ->make(true);
    }

    public function saveplan($id)
    {
        $data = Plans::find($id);
        return view("admin.plan.saveplan")->with("id", $id)->with("data", $data);
    }

    public function updateplan(Request $request)
    {

        if ($request->get("id") == 0) {
            $store = new Plans();
            $msg = __("message.Plan Add Successfully");
            $img_url = "no-image.jpg";
            $rel_url = "";
        } else {
            $store = Plans::find($request->get("id"));
            $msg = __("message.Plan Update Successfully");
            $img_url = $store->image;
            $rel_url = $store->image;
        }
        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $folderName = '/upload/plans/';
            $picture = time() . '.' . $extension;
            $destinationPath = public_path() . $folderName;
            $request->file('image')->move($destinationPath, $picture);
            $img_url =$picture;
            $image_path = public_path() ."/upload/plans/".$rel_url;
            if(file_exists($image_path)&&$rel_url!="") {
                try {
                    unlink($image_path);
                }
                catch(Exception $e) {

                }
            }
        }
        $store->name=$request->get("name");
        $store->image=$img_url;
        $store->save();
        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect("admin/plans");
    }

    public function deleteplan($id){
        $plan=Plans::find($id);
        if($plan){
            $image_path = public_path() ."/upload/plans/".$plan->image;
            if(file_exists($image_path)&&$plan->image!="") {
                try {
                    unlink($image_path);
                }
                catch(Exception $e) {
                }
            }
            $plan->delete();
        }
        Session::flash('message',__("message.Plan Delete Successfully"));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
}
