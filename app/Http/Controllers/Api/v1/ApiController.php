<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function payload($data = [], $status = 200) {
	    return response()->json($data, $status, []);
	}
}