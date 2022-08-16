<?php

namespace App\Models;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory, HasSlug;

    protected $fillable =[
        'business_name',
        'business_email',
        'slug'
    ];

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
