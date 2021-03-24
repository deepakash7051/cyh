<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageUpload extends Model
{
    protected $fillable = [  
        'title',
        'filename',
        'user_id'
    ];

    public static function laratablesCustomAction($design)
    {
        return view('admin.designs.action', compact('design'))->render();
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

}
