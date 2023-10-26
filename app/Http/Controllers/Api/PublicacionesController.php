<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Files;
use App\Models\Publicaciones;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicacionesController extends Controller
{


    public function store(Request $request){
        try{
            $validate = Validator::make($request->all(), [
                'data' => 'required'
            ]);

            if($validate->fails()){
                return response()->json([
                    'errors' => $validate->errors(),
                    'status' => false,
                    'message' => 'Error en los datos ingresados'
                ],400);
            }
            $data = json_decode($request->data);
            $fecha_creacion = Carbon::parse($data->fecha_creacion);
            $publicacion = Publicaciones::create([
                'tipo_publicacion_id' => 1,
                'titulo' => $data->titulo,
                'descripcion' => $data->descripcion,
                'fecha_creacion' =>$fecha_creacion,
                'user_id' => $data->user_id,
                'contenido' => $data->contenido,
            ]);

            $files = $request->allFiles();
            if (true) {
                foreach($files as $file){
                    $extension =  $file->getClientOriginalExtension();
                    $path = "";
                    $fileName = $file->getClientOriginalName();
                    if($extension == 'glb' || $extension == 'gltf'){
                        $path = $file->storeAs('public/proyecto/'.$publicacion->id.'/model', $file->getClientOriginalName());
                    }else{
                        $path = $file->storeAs('public/proyecto/'.$publicacion->id.'/img', $file->getClientOriginalName());
                    }
                    Files::create([
                        'user_id' => $data->user_id,
                        'nombre' => $fileName,
                        'path' => $path,
                        'formato' => $extension,
                        'publicacion_id' => $publicacion->id
                    ]);
                }
            }
            return response()->json([
                'status' => true,
                'message' => 'Proyecto creado con exito'
            ],200);
        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al agregar proyecto'
            ],400);
        }



    }


}
