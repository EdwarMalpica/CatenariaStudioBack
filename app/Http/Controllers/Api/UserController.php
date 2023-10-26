<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


class UserController extends Controller
{
    //Obtener datos del usuario autenticado
    public function show(){
        try{
            $user = auth()->user();
            return response()->json([
                'status' => true,
                'user' => [
                    'id' => $user->id,
                    'nombres' => $user->detalle->nombres,
                    'apellidos' => $user->detalle->apellidos,
                    'fecha_nacimiento' => $user->detalle->fecha_nacimiento,
                    'numero_telefonico' => $user->detalle->numero_telefonico,
                ]
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function verifyEmail (EmailVerificationRequest $request) {
        try{
            $request->fulfill();
            return response()->json([
                'status' => true,
                'message' => "Email verificado"
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }

            

    }
}
