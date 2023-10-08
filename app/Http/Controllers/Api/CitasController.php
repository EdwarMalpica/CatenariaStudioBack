<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Citas;
use App\Models\User;
use Exception;

class CitasController extends Controller
{

    public function index(){
        try{

            return response()->json([
                'status' => true,
                'citas' => Citas::all(['id','fecha_cita','mensaje','user_id','estado_cita_id'])->map(function($cita){
                    $user = User::where('id', $cita->user_id)->first();
                    $user->detalle = $user->detalle;
                    $cita->user = $user;
                    return $cita;
                })
            ],200);
        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al obtener las citas'
            ],400);
        }
    }
}
