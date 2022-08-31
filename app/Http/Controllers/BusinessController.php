<?php

namespace App\Http\Controllers;

use App\Helper\Datatable;
use App\Helper\MediaHelper;
use App\Http\Requests\BusinessRequest;
use App\Http\Resources\BusinessDetailResource;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\EditBusinessResource;
use Illuminate\Support\Str;
use App\Models\business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BusinessController extends Controller
{
    public function index(){
        $busineses = Business::with('category');
        $busineses = Datatable::filter($busineses,['name']);
        return BusinessResource::collection($busineses);
    }

    public function myBusiness(){
        $busineses = Business::with('category')->where('user_id',auth()->id());
        $busineses = Datatable::filter($busineses,['business_name']);
        return BusinessResource::collection($busineses);
    }

    public function businessDetail($id){
        $business = Business::findOrFail($id);
        $files= $business->getMedia('business');
        $image_data = [];
        if(count($files)>0){
            foreach($files as $file){
                $data['original_url']= $file->getUrl();
                $data['thumb_url'] =  $file->getUrl('thumb');
                array_push($image_data,$data);
            }
        }
        $business['images']= $image_data;
        if(Auth::user()->hasRole('admin') || Auth::id() == $business->user_id){
            return new BusinessDetailResource($business);
        }else{
            abort(403,'permission denied');
        }
    }

    public function edit($id){
       
        $business = Business::findOrFail($id);
        return  new EditBusinessResource($business);
    }

    public function store(BusinessRequest $request){

        //return $request->all();
        try{
            DB::beginTransaction();
            $slug = Str::slug($request->business_name);
            $business_logo = MediaHelper::saveCoverImage($request->business_logo,'business', $slug);
            $business = new Business();
            $business->business_name = $request->business_name;
            $business->business_email = $request->business_email;
            $business->full_address = $request->full_address;
            $business->about = $request->business_detail;
            $business->business_started_date = $request->business_started_date;
            $business->contact_number = $request->contact_number;
            $business->category_id = $request->category_id;
            $business->created_by = auth()->id();
            $business->user_id = auth()->id();
            $business->business_logo = $business_logo;
            $business->save();
            if($request->file('business_images')) {
                foreach ($request->file('business_images') as $photo) {
                    $business->addMedia($photo)->toMediaCollection('business','public');
                }
            }
            DB::commit();
            return response()->json([
                'message'=>'New business added successfully.'
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
            'full_address'=>'required|max:200',
            'category_id'=>'required',
        ]);
        $business = Business::findOrFail($id);
        
        try{
            DB::beginTransaction();
            $slug = Str::slug($request->business_name);
            $business_logo = $business->business_logo;
            if($request->has('business_logo')){
                MediaHelper::deleteFile($business->business_logo,'business');
                $business_logo = MediaHelper::saveCoverImage($request->business_logo,'business', $slug);
            }
            $business->business_name = $request->business_name;
            $business->business_email = $request->business_email;
            $business->full_address = $request->full_address;
            $business->about = $request->business_detail;
            $business->business_started_date = $request->business_started_date;
            $business->contact_number = $request->contact_number;
            $business->category_id = $request->category_id;
            $business->created_by = auth()->id();
            $business->user_id = auth()->id();
            $business->business_logo = $business_logo;
            $business->update();
            
            DB::commit();
            return response()->json([
                'message'=>'business updated successfully.'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message'=>$e->getMessage()
            ],419);
            DB::rollBack();

        }
        
        


    }

    public function changeStatus($id){
        $business = Business::findOrFail($id);
        if(Auth::user()->hasRole('admin') || Auth::id() == $business->user_id){
            $business->status = !$business->status;
            $business->update();
            return response()->json([
                'message'=>'business status updated succefully.'
            ],200);
        }
        return response()->json([
            'message'=>'unauthorized action'
        ],403);
    }

    public function delete($id){
        $business = Business::findOrFail($id);
        if(Auth::user()->hasRole('admin') || Auth::id() == $business->user_id){
            $business->delete();
            return response()->json([
                'message'=>'business deleted succefully.'
            ],200);
        }
        return response()->json([
            'message'=>'unauthorized action'
        ],403);
        
    }
}
