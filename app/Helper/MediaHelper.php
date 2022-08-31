<?php
namespace App\Helper;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MediaHelper{
    public static function storeMedia($file,$path,$thumbnail=false, $icon=false,$image_type=true){
        // return config('minio');
        if ($file) {
            
            $currentDate = Carbon::now()->toDateString();
            $fileName = $currentDate.'-'.uniqid().'.'.$file->getClientOriginalExtension();
            if($image_type){
                if($thumbnail){
                    $thumb = Image::make($file)->resize(200,150,function($constrain){
                        $constrain->aspectRatio();
                      })
                      ->stream();
                      Storage::disk('public')->put('thumb/'.$fileName,$thumb);
                }
                $image = Image::make($file)->stream();
                Storage::disk('public')->put($path.'/'.$fileName, $image);
                return $fileName;
            }else{
                Storage::disk('public')->put($path.'/'.$fileName, $file);
                return $fileName;
            }

        }
    }

    public static function saveCoverImage($file,$path,$name){        
            $currentDate = Carbon::now()->toDateString();
            $fileName = $name.'-'.$currentDate.'-'.uniqid().'.'.$file->getClientOriginalExtension();
            
            $file->storeAs($path,$fileName);
            $thumb = Image::make($file)->resize(200,150,function($constrain){
                $constrain->aspectRatio();
            })
            
            ->stream();
            Storage::put('thumb/'.$fileName,$thumb);                 
            return $fileName;
    }

    public static function deleteFile($fileName,$path){
        $thumb = 'thumb/'.$fileName;
        $file = $path.'/'.$fileName;
        if (Storage::disk('public')->exists($file)) {
            Storage::delete($file);
        }

        if (Storage::disk('public')->exists($thumb)) {
            Storage::delete($thumb);
        }
    }

    public static function getLink($image, $valid_till = 5)
    {
        // $file = $this->directory.'/'.$this->filename.'.'.$this->extension;
        // return Storage::disk('minio')->temporaryUrl($file,Carbon::now()->addDays(7));
        if ($image) {
            return Storage::disk('public')->temporaryUrl($image, Carbon::now()->addMinute($valid_till));
        }
        return null;
    }

    public static function getThumbnailUrl($image,$path){
        $file = $path.'/'.$image;
        return Storage::disk('public')->url($file);
    }
    public static function getImageUrl($image,$path){
        $file = $path.'/'.$image;
        return Storage::disk('public')->url($file);
    }
}
