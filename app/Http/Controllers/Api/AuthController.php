<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Datos_Usuarios;
use App\Models\Logs;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;


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
                'password' => 'required',
                'nombres' => 'required',
                'apellidos' => 'required',
                'fecha_nacimiento' => 'required',
                'numero_telefonico' => 'required'
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


            if (!$user) {

                return response()->json([
                    'status' => false,
                    'message' => 'Error al crear el usuario',
                ], 500);
            }

            $user_id = $user->id;
            $fecha_nacimiento = date('Y-m-d', strtotime($request->fecha_nacimiento));
            Datos_Usuarios::create([
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'fecha_nacimiento' => $fecha_nacimiento,
                'numero_telefonico' => $request->numero_telefonico,
                'user_id' => $user_id
            ]);
            $user->detalle;
            Logs::create([
                'tipo_log_id' => 2,
                'descripcion' => 'Se ha registrado un nuevo usuario',
                'ip' => $request->ip()
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Usuario creado exitosamente',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'user' => $user
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
            //Validacion del request en el login
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
            $user->detalle;
            Logs::create([
                'tipo_log_id' => 1,
                'descripcion' => 'Ingreso al sistema',
                'ip' => $request->ip()
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Usuario logeado exitosamente',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'user' => $user
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
            Logs::create([
                'tipo_log_id' => 8,
                'descripcion' => 'Se ha deslogeado del sistema',
                'ip' => request()->ip()
            ]);
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
