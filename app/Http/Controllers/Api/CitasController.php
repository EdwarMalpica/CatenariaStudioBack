<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Citas;
use App\Models\EstadoCita;
use App\Models\Logs;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitasController extends Controller
{

    public function index(){
        try{

            Logs::create([
                'tipo_log_id' => 7,
                'descripcion' => 'Obtener Citas',
                'ip' => request()->ip()
            ]);
            return response()->json([
                'status' => true,
                'citas' => Citas::all(['id','fecha_cita','mensaje','user_id','estado_cita_id'])->map(function($cita){
                    $user = User::where('id', $cita->user_id)->first();
                    $user->detalle = $user->detalle;
                    $user->numero_telefonico = $user->detalle->numero_telefonico;
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
    public function show(Citas $cita){
        try{
            $cita->estado;
            $cita->user;
            $cita->user->detalle;
            $cita->user->detalle->numero_telefonico;
            return response()->json([
                'status' => true,
                'cita' => $cita
            ],200);
        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al obtener la cita'
            ],400);
        }
    }

    public function indexUser(){
        try{
            Logs::create([
                'tipo_log_id' => 7,
                'descripcion' => 'Obtener Citas de usuario',
                'ip' => request()->ip()
            ]);
            return response()->json([
                'status' => true,
                'citas' => auth()->user()->citas->map(function ($cita){
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
            Logs::create([
                'tipo_log_id' => 7,
                'descripcion' => 'Obtener Estados de Citas',
                'ip' => request()->ip()
            ]);
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
            Logs::create([
                'tipo_log_id' => 5,
                'descripcion' => 'Se ha registrado una nueva cita',
                'ip' => request()->ip()
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

    public function edit(Citas $citas){
        try{
            $citas->estado;

            return response()->json([
                'status' => true,
                'cita' => $citas,
                'estados' => EstadoCita::all()
            ]);
        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al obtener la cita'
            ],400);
        }
    }

    public function update(Request $request){
        try{
            $validate = Validator::make($request->all(), [
                'id' => 'required',
                'fecha_cita' => 'required',
                'mensaje' => 'required',
                'estado_cita_id' => 'required',
            ]);

            if($validate->fails()){
                return response()->json([
                    'errors' => $validate->errors(),
                    'status' => false,
                    'message' => 'Error al actualizar la cita, o cita no encontrada'
                ],400);
            }

            $fecha_cita = Carbon::parse($request->fecha_cita);
            $cita = Citas::where('id', $request->id)->first();
            $cita->fecha_cita = $fecha_cita;
            $cita->mensaje = $request->mensaje;
            $cita->estado_cita_id = $request->estado_cita_id;
            $cita->save();
            Logs::create([
                'tipo_log_id' => 7,
                'descripcion' => 'Se ha actualizado una cita',
                'ip' => request()->ip()
            ]);
            return response()->json([
                'status' => true,
                'mensaje' => 'Cita Actualizada correctamente'
            ]);

        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al actualizar la cita'
            ],400);
        }
    }

    public function destroy(Citas $cita){
        try{

            $cita->delete();
            Logs::create([
                'tipo_log_id' => 7,
                'descripcion' => 'Se ha eliminado una cita',
                'ip' => request()->ip()
            ]);
            return response()->json([
                'status' => true,
                'mensaje' => 'Cita Eliminada correctamente'
            ]);
        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al actualizar la cita'
            ],400);
        }
    }

}
