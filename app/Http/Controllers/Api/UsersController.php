<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorksInProgressResource;
use App\Http\Resources\UserWipsCollection;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function wips(string $id)
    {
        try
        {
            //Find user
            $exists = User::find($id);
            if($exists == null)
            {
                return response()->json((["Error"=>"Usuario no encontrado"]));
            }

            //Return whit all wips
            $wips = User::where('user_id',$id)->with('wips')->get();
            return UserWipsCollection::collection($wips);
        }
        catch(Exception $ex)
        {
            return response()->json((["Error"=>$ex->getMessage()]));
        }
    }
}
