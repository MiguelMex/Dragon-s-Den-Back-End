<?php

namespace App\Http\Controllers\Api;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        try
        {
            $users = User::all();
            return UserResource::collection($users);
        }
        catch (Exception $ex)
        {
            return response()->json(['error'=>$ex]);
        }
    }

    public function register(Request $request)
    {
        $creator = new CreateNewUser();
        $user = $creator->create($request->all());

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email','password')))
        {
            throw ValidationException::withMessages([
                'email'=>['Las credenciales proporcionadas son incorrectas.']
            ]);
        }

        $user = User::where('email',$request->email)->firstOrFail();
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'usuario' => new UserResource($user),
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'Sesion cerrada corrctamente']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $updater = new UpdateUserProfileInformation();
        $updater->update($user,$request->all());
        return response()->json(['message'=>'Perfil actualizado','user'=>$user]);
        
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if(!Hash::check($request->current_password, $user->password))
        {
            throw ValidationException::withMessages([
                'current_password' => ['La contraseña actual no coincide.'],
            ]);
        }

        $updater = new UpdateUserPassword();
        $updater->update($user,$request->all());

        return response()->json(['message'=>'Contraseña actualizada']);
    }
}
