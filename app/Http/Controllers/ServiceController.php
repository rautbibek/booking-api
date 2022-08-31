<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Helper\Datatable;
use App\Helper\MediaHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\EditServiceResource;
use App\Http\Resources\ServiceResource;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index(){
        $services = Service::with('category');
        $services = Datatable::filter($services,['name']);
        return ServiceResource::collection($services);
    }

    public function myService(){
        $services = Service::with('category')->where('user_id',auth()->id());
        $services = Datatable::filter($services,['business_name']);
        return ServiceResource::collection($services);
    }

    public function edit($id){
       
        $service = Service::findOrFail($id);
        return  new EditServiceResource($service);
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
            $service->business_started_date = $request->business_started_date;
            $service->contact_number = $request->contact_number;
            $service->category_id = $request->category_id;
            $service->created_by = auth()->id();
            $service->user_id = auth()->id();
            $service->business_logo = $business_logo;
            $service->save();
            if($request->file('business_images')) {
                foreach ($request->file('business_images') as $photo) {
                    $service->addMedia($photo)->toMediaCollection();
                }
            }
            DB::commit();
            return response()->json([
                'message'=>'New service addes successfully.'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message'=>$e->getMessage()
            ],419);
            DB::rollBack();

        }
        
    }

    public function update(Request $request,$id){
        
        $this->validate($request,[
            'business_logo'=>'sometimes|image|mimes:png,jpg,jpeg,webp,gif|max:8000',
            'business_name'=>'required|max:200',
            'business_email'=>'required|email|max:100',
            'contact_number'=>'required|numeric',
            'business_started_date'=>'required|date',
            // 'business_images' => 'required',
            // 'business_images.*' => 'required|image|mimes:jpg,jpeg,png,gif|max:10048',
            'full_address'=>'required|max:200',
            'category_id'=>'required',
        ]);
        $service = Service::findOrFail($id);
        
        try{
            DB::beginTransaction();
            $slug = Str::slug($request->business_name);
            $business_logo = $service->business_logo;
            if($request->has('business_logo')){
                MediaHelper::deleteFile($service->business_logo,'service');
                $business_logo = MediaHelper::saveCoverImage($request->business_logo,'service', $slug);
            }
            $service->business_name = $request->business_name;
            $service->business_email = $request->business_email;
            $service->full_address = $request->full_address;
            $service->about = $request->business_detail;
            $service->business_started_date = $request->business_started_date;
            $service->contact_number = $request->contact_number;
            $service->category_id = $request->category_id;
            $service->created_by = auth()->id();
            $service->user_id = auth()->id();
            $service->business_logo = $business_logo;
            $service->update();
            
            DB::commit();
            return response()->json([
                'message'=>'service updatedf successfully.'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message'=>$e->getMessage()
            ],419);
            DB::rollBack();

        }
        
        


    }

    public function changeStatus($id){
        $service = Service::findOrFail($id);
        if(Auth::user()->hasRole('admin') || Auth::id() == $service->user_id){
            $service->service_status = !$service->service_status;
            $service->update();
            return response()->json([
                'message'=>'service status changed succefully.'
            ],200);
        }
        return response()->json([
            'message'=>'unauthorized action'
        ],403);
    }

    public function delete($id){
        $service = Service::findOrFail($id);
        if(Auth::user()->hasRole('admin') || Auth::id() == $service->user_id){
            $service->delete();
            return response()->json([
                'message'=>'service deleted succefully.'
            ],200);
        }
        return response()->json([
            'message'=>'unauthorized action'
        ],403);
        
    }
}
