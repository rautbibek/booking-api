<?php

namespace App\Models;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory,HasSlug;
    protected $guarded =['*'];
    protected $fillable = [
        'name','status','has_package','package_names','slug','image'
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    protected $casts = [
        'package_names'=>'array',
        'has_package'=>'boolean'
    ];
}

