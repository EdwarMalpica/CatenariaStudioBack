<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Citas;
use App\Models\EstadoCita;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
                    $cita->estado;
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

    public function create(){
        try{
            return response()->json([
                'status' => true,
                'estados_citas' => EstadoCita::all(['id','nombre'])
            ]);
        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al obtener los estados de citas'
            ],400);
        }
    }

    public function store(Request $request){
        try{
            $validate = Validator::make($request->all(), [
                'fecha_cita' => 'required',
                'mensaje' => 'required',
                'estado_cita_id' => 'required',
            ]);

            if($validate->fails()){
                return response()->json([
                    'errors' => $validate->errors(),
                    'status' => false,
                    'message' => 'Error al registrar cita'
                ],400);
            }

            $fecha_cita = Carbon::parse($request->fecha_cita);
            $user = auth()->user();
            Citas::create([
                'fecha_cita' => $fecha_cita,
                'mensaje' => $request->mensaje,
                'user_id' => $user->id,
                'estado_cita_id' => $request->estado_cita_id
            ]);

            return response()->json([
                'status' => true,
                'messages' => 'Cita Creada correctamente'
            ],200);

        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al obtener los estados de citas'
            ],400);
        }
    }

}
