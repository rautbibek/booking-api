<?php

namespace App\Models;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model implements HasMedia
{
    use HasFactory,HasSlug,InteractsWithMedia;
    protected $fillable =[
        'business_name',
        'business_email',
        'business_logo',
        'contact_number',
        'full_address',
        'category_id',
        'slug'
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(368)
              ->height(232)
              ->sharpen(10);
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('business_name')
            ->saveSlugsTo('slug');
    }

    public function category(){
       return  $this->belongsTo(Category::class);
    }
}
