<?php

namespace App\Http\Controllers;

use App\Models\TypeService;
use Illuminate\Http\Request;
use Session;
use DataTables;

class TypeServiceController extends Controller
{
    public function showtypesservices()
    {
        return view("admin.typeservice.default");
    }

    public function typeservicestable()
    {
        $services = TypeService::all();

        return DataTables::of($services)
            ->editColumn('id', function ($services) {
                return $services->id;
            })
            ->editColumn('type', function ($services) {
                return strtoupper($services->type);
            })
            ->editColumn('name', function ($services) {
                return $services->name;
            })
            ->editColumn('description', function ($services) {
                return $services->description;
            })
            ->editColumn('price', function ($services) {
                return "R$" . number_format($services->price, 2, ',', '.');
            })
            ->editColumn('displacementrate', function ($services) {
                return "R$" . number_format($services->displacement_rate, 2, ',', '.');
            })
            ->editColumn('action', function ($services) {
                $edit = url('admin/savetypeservice', array('id' => $services->id));
                $delete = url('admin/deletetypeservice', array('id' => $services->id));
                $return = '<a  rel="tooltip" title="" href="' . $edit . '" class="m-b-10 m-l-5" data-original-title="Remove"><i class="fa fa-edit f-s-25" style="margin-right: 10px;"></i></a><a onclick="delete_record(' . "'" . $delete . "'" . ')" rel="tooltip" title="" class="m-b-10 m-l-5" data-original-title="Remove"><i class="fa fa-trash f-s-25"></i></a>';
                return $return;
            })
            ->make(true);
    }

    public function savetypeservice($id)
    {
        $data = TypeService::find($id);
        $types = TypeService::listServices();
        return view("admin.typeservice.savetypeservice")->with("id", $id)->with("data", $data)->with('types', $types);
    }

    public function updatetypeservice(Request $request)
    {
        if ($request->get("id") == 0) {
            $store = new TypeService();
            $msg = __("message.Type Service Add Successfully");
        } else {
            $store = TypeService::find($request->get("id"));
            $msg = __("message.Type Service Update Successfully");
        }
        $store->name = $request->get("name");
        $store->type = $request->get("type");
        $store->description = $request->get("description");
        $store->producer = $request->get("producer");
        $store->price = $request->get("price");
        $store->displacement_rate = $request->get("displacement_rate");
        $store->save();
        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect("admin/typeservices");
    }

    public function deletetypeservice($id){
        $typeservice=TypeService::find($id);
        if($typeservice){
            $typeservice->delete();
        }
        Session::flash('message',__("message.Type Service Delete Successfully"));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
}
