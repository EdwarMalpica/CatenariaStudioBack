<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Crear un nuevo usuario
     * @Param Request $request
     * @return User
     */
    public function createUser(Request $request)
    {
        try {
            //Validar usuarioa
            $validateUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);
            if($validateUser->fails()){
                return response()->json([
                    'errors' => $validateUser->errors(),
                    'status' => false,
                    'message' => 'Error en la validacion'
                ],401);
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Usuario creado exitosamente',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ],200);

        }catch (\Throwable $th)
        {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login del User
     * @param request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validacion con error',
                    'errors' => $validateUser->errors()
                ],401);
            }

            if(!Auth::attempt($request->only(['email','password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email y contraseña no concuerda con ningun usuario'
                ],401);
            }
            $user = User::where('email',$request->email)->first();
            return response()->json([
                'status' => true,
                'message' => 'Usuario logeado exitosamente',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ],200);
        }catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    //Logout the user
    public function destroy()
    {
        try {
            auth()->user()->tokens()->delete();
            return response()->json([
                'status' => true,
                'message' => 'Logout exitoso'
            ],200);
        }catch(Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ],500);
        }

    }
}
