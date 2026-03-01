<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestResource;
use Illuminate\Http\Request;
use App\Models\User;

class TestController extends Controller
{
    //
    public function index(){
        return TestResource::collection(User::all());
    }
}
