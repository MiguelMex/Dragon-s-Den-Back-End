<?php

namespace App\Http\Controllers\Api;
use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * get all users
     *
     */
    public function index()
    {
        try {
            $users = User::all();
            return UserResource::collection($users);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }

    /**
     * store a user
     * 
     */
    public function store(StoreUserRequest $request)
    {
        try {
            return response()->json(['Check'=>'llega hasta aquí']);
            $creator = new CreateNewUser();
            $user = $creator->create($request->all());
            //generar token
            $token = $user->createToken('auth-token')->plainTextToken;
            return response()->json(['user'=>$user,'token'=>$token],201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }
}
