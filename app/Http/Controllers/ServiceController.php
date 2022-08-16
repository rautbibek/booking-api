<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Helper\Datatable;
use App\Helper\MediaHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServiceResource;

class ServiceController extends Controller
{
    public function index(){
        $services = Service::with('category');
        $services = Datatable::filter($services,['name']);
        return ServiceResource::collection($services);
    }

    public function myService(){
        $services = Service::with('category');
        $services = Datatable::filter($services,['name']);
        return ServiceResource::collection($services);
    }

    public function store(ServiceRequest $request){

        //return $request->all();
        try{
            DB::beginTransaction();
            $slug = Str::slug($request->business_name);
            $business_logo = MediaHelper::saveCoverImage($request->business_logo,'service', $slug);
            $service = new Service();
            $service->business_name = $request->business_name;
            $service->business_email = $request->business_email;
            $service->full_address = $request->full_address;
            $service->about = $request->business_detail;
            $service->category_id = $request->category_id;
            $service->created_by = auth()->id();
            $service->user_id = auth()->id();
            $service->business_logo = $business_logo;
            $service->save();
            DB::commit();
            return response()->json([
                'message'=>'New service addes succefully.'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message'=>$e->getMessage()
            ],419);
            DB::rollBack();

        }
        
    }
}
