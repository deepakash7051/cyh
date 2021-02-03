<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    /*public function __construct()
	{
	    $this->setFillable();
	}
	public function setFillable()
	{
	    $fields = \Schema::getColumnListing('categories');

	    $this->fillable[] = $fields;
	}*/

	protected $fillable = [  
        'en_name',
        'en_description',
        'bn_name',
        'bn_description',
        'zh-TW_name',
        'zh-TW_description',
        'ta_name',
        'ta_description',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public static function laratablesCustomAction($category)
    {
        return view('admin.categories.action', compact('category'))->render();
    }
}
