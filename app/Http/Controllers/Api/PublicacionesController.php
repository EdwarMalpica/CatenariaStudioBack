<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Files;
use App\Models\Publicaciones;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PublicacionesController extends Controller
{

    public function index(){
        try {

            return response()->json([
                'status' => true,
                'proyectos' => Publicaciones::where('tipo_publicacion_id', 1)
                ->get(['id','tipo_publicacion_id','titulo','fecha_creacion','descripcion','miniatura_path'])->map(function($proyecto){
                    Storage::setVisibility($proyecto->miniatura_path, 'public');
                    $proyecto->miniatura_path = Storage::url($proyecto->miniatura_path);
                    return $proyecto;
                })
            ]);
        } catch (Exception $th) {
            return response()->json([
                'errors' => $th->getMessage(),
                'status' => false,
                'message' => 'Error al traer los proyectos'
            ],400);
        }
    }

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
                'miniatura_path' => ''
            ]);

            $files = $request->allFiles();
            if (true) {
                foreach($files as $file){
                    $extension =  $file->getClientOriginalExtension();
                    $path = "";
                    $miniaturaPath = "";
                    $fileName = $file->getClientOriginalName();
                    if($extension == 'glb' || $extension == 'gltf'){
                        $path = $file->storeAs('public/proyecto/'.$publicacion->id.'/model', $file->getClientOriginalName());
                    }else if($file == $request->file('miniatura')){
                        $miniaturaPath = $file->storeAs('public/proyecto/'.$publicacion->id.'/img', 'minuatura_'.$publicacion->id.'.'.$extension);
                    }else{
                        $path = $file->storeAs('public/proyecto/'.$publicacion->id.'/img', $file->getClientOriginalName());
                    }
                    $publicacion->miniatura_path = $miniaturaPath;
                    $publicacion->save();
                    Files::create([
                        'user_id' => $data->user_id,
                        'nombre' => $fileName,
                        'path' => $path,
                        'formato' => $extension,
                        'publicacion_id' => $publicacion->id,
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

    public function show(Publicaciones $publicaciones){
        try{
            $publicaciones->files->map(function($file){
                $file->path = Storage::url($file->path);
                return $file;
            });
            $publicaciones->miniatura_path = Storage::url($publicaciones->miniatura_path);
            return response()->json([
                'status' => true,
                'publicacion' => $publicaciones
            ]);

        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al agregar proyecto'
            ],400);
        }
    }


}
