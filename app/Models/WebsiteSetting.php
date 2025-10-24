<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    protected $fillable = ['logo', 'banner_image', 'banner_tagline' , 'about_image', 'about_heading', 'about_description'];
}
