<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    protected $fillable = [  
        'user_id',
        'image_name'
    ];

    protected $hidden = [  
        'id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function user_image(){
        return $this->belongsTo('App\User');
    }
}
