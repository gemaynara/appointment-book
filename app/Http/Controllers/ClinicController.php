<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\TypeService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Session;
use DataTables;
use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function showclinics()
    {
        return view("admin.clinic.default");
    }

    public function clinicstable()
    {
        $clinics = Clinic::all();

        return DataTables::of($clinics)
            ->editColumn('id', function ($clinics) {
                return $clinics->id;
            })
            ->editColumn('image', function ($clinics) {
                return asset("upload/clinics/" . $clinics->image);
            })
            ->editColumn('name', function ($clinics) {
                return $clinics->name;
            })
            ->editColumn('cnpj', function ($clinics) {
                return ($clinics->cnpj);
            })
            ->editColumn('email', function ($clinics) {
                return $clinics->email;
            })
            ->editColumn('phone', function ($clinics) {
                return $clinics->phone;
            })
            ->editColumn('services', function ($clinics) {
                $services = explode(",", $clinics->services);
                $data = TypeService::listServices();
                foreach ($services as $key => $value) {
                    if (isset($data[$value])) {
                        $services[$key] = $data[$value];
                    }
                }
                return $services;
            })
            ->editColumn('action', function ($clinics) {
                $edit = url('admin/saveclinic', array('id' => $clinics->id));
                $delete = url('admin/deleteclinic', array('id' => $clinics->id));
                $return = '<a  rel="tooltip" title="" href="' . $edit . '" class="m-b-10 m-l-5" data-original-title="Remove"><i class="fa fa-edit f-s-25" style="margin-right: 10px;"></i></a><a onclick="delete_record(' . "'" . $delete . "'" . ')" rel="tooltip" title="" class="m-b-10 m-l-5" data-original-title="Remove"><i class="fa fa-trash f-s-25"></i></a>';
                return $return;
            })
            ->make(true);
    }

    public function saveclinic($id)
    {
        $data = Clinic::find($id);
        $services = TypeService::listServices();
        return view("admin.clinic.saveclinic")
            ->with("id", $id)
            ->with("data", $data)
            ->with("services", $services);
    }

    public function updateclinic(Request $request)
    {

        if ($request->get("id") == 0) {
            $store = new Clinic();
            $msg = __("message.Clinic Add Successfully");
            $img_url = "no-image.jpg";
            $rel_url = "";
            $filename_license = "";
            $filename_health = "";
        } else {
            $store = Clinic::find($request->get("id"));
            $msg = __("message.Clinic Update Successfully");
            $img_url = $store->image;
            $rel_url = $store->image;
            $filename_license = $store->license_file;
            $filename_health = $store->license_health_file;
        }
        if ($request->hasFile('upload_image')) {
            $file = $request->file('upload_image');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $folderName = '/upload/clinics/';
            $picture = time() . '.' . $extension;
            $destinationPath = public_path() . $folderName;
            $request->file('upload_image')->move($destinationPath, $picture);
            $img_url = $picture;
            $image_path = public_path() . "/upload/clinics/" . $rel_url;
            if (file_exists($image_path) && $rel_url != "") {
                try {
                    unlink($image_path);
                } catch (Exception $e) {

                }
            }
        }
        if ($request->file('license_file')) {
            $file = $request->file('license_file');
            $filename_license = $file->getClientOriginalName();
            Storage::disk('upload')->put("/clinics/files/" . $filename_license, File::get($file));
        }
        if ($request->file('license_health_file')) {
            $file = $request->file('license_health_file');
            $filename_health = $file->getClientOriginalName();
            Storage::disk('upload')->put("/clinics/files/" . $filename_health, File::get($file));
        }
        $store->name = $request->get("name");
        $store->corporate_name = $request->get("corporate_name");
        $store->cnpj = $request->get("cnpj");
        $store->email = $request->get("email");
        $store->phone = $request->get("phone");
        $store->contact_person = $request->get("contact_person");
        $store->agency = $request->get("agency");
        $store->account = $request->get("account");
        $store->license_file = $filename_license;
        $store->license_expired_at = $request->get("license_expired_at");
        $store->license_health_file = $filename_health;
        $store->license_health_expired_at = $request->get("license_health_expired_at");
        $store->services = implode(",", $request->get('services'));
        $store->image = $img_url;
        $store->save();
        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect("admin/clinics");
    }

    public function deleteclinic($id)
    {
        $clinic = Clinic::find($id);
        if ($clinic) {
            $image_path = public_path() . "/upload/clinics/" . $clinic->image;
            $license_file = public_path() . "/upload/clinics/files/" . $clinic->license_file;
            $license_health = public_path() . "/upload/clinics/files/" . $clinic->license_health_file;
            if (file_exists($image_path) && $clinic->image != "") {
                try {
                    unlink($image_path);
                } catch (Exception $e) {
                }
            }
            file_exists($license_file) ?? unlink($license_file);
            file_exists($license_health) ?? unlink($license_health);
            $clinic->delete();
        }
        Session::flash('message', __("message.Clinic Delete Successfully"));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function viewlicense(Request $request)
    {
        $path = public_path() . "/upload/clinics/files/" . $request->filename;
        return response()->file($path);
    }
}
