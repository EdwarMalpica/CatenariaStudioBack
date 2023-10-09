<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FranjaHoraria;
use App\Models\Horario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HorariosController extends Controller
{
    public function index(){
        try{
            $horarios = Horario::all(['id','dia','active']);
            $horarios->map(function(Horario $horarios){
                $horarios->franjas = $horarios->franjas()->get(['hora_inicio','hora_fin']);
                return  $horarios;
            });

            return response()->json([
                'horarios' => $horarios,
                'status' => true
            ]);

        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al obtener los horarios'
            ],400);
        }
    }

    public function store(Request $request){
        try{
            $validate = Validator::make($request->all(), [
                'horarios' => 'required'
            ]);

            if($validate->fails()){
                return response()->json([
                    'errors' => $validate->errors(),
                    'status' => false,
                    'message' => 'Error al actualizar los horarios'
                ],400);
            }
            $horarios = $request->horarios;
            FranjaHoraria::truncate();
            foreach($horarios as $hor){
                $dia = Horario::find($hor['id']);
                $dia->active =$hor['active'];
                $dia->save();
                $franjas = $hor['franjas'];
                foreach($franjas as $franja){
                    print(" ".$franja['hora_inicio']);
                    $franjaCreada = FranjaHoraria::create([
                        'hora_inicio'=> $franja['hora_inicio'],
                        'hora_fin'=> $franja['hora_fin'],
                        'horario_id'=> $hor['id'],
                    ]);
                    if(!$franjaCreada){
                        return response()->json([
                            'status' => false,
                            'message' => 'Error al crear la franja',
                        ], 400);
                    }
                }
            }
            return response()->json([
                'status' => true,
                'message' => 'Horarios actualizados correctamente.'
            ],200);
        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al actualizar los horarios'
            ],400);
        }
    }
}
