<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Files;
use App\Models\Logs;
use App\Models\Publicaciones;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticlesController extends Controller
{
    public function index(){
        try{
            Logs::create([
                'tipo_log_id' => 7,
                'descripcion' => 'Obtener Articulos',
                'ip' => request()->ip()
            ]);
            return response()->json([
                'status' => true,
                'articulos' => Publicaciones::where('tipo_publicacion_id', 2)
                ->get(['id','tipo_publicacion_id','titulo','fecha_creacion','descripcion','miniatura_path'])->map(function($articulos){
                    Storage::setVisibility($articulos->miniatura_path, 'public');
                    $articulos->miniatura_path = Storage::url($articulos->miniatura_path);
                    return $articulos;
                })
            ]);
        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al obtener los articulos'
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
                'tipo_publicacion_id' => 2,
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
                        $path = $file->storeAs('public/articulo/'.$publicacion->id.'/model', $file->getClientOriginalName());
                    }else if($file == $request->file('miniatura')){
                        $miniaturaPath = $file->storeAs('public/articulo/'.$publicacion->id.'/img', 'minuatura_'.$publicacion->id.'.'.$extension);
                        $path = $miniaturaPath;
                        $publicacion->miniatura_path = $miniaturaPath;
                    }else{
                        $path = $file->storeAs('public/articulo/'.$publicacion->id.'/img', $file->getClientOriginalName());
                    }

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
            Logs::create([
                'tipo_log_id' => 7,
                'descripcion' => 'Se ha registrado un nuevo articulo',
                'ip' => $request->ip()
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Articulo creado con exito'
            ],200);
        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al agregar el articulo'
            ],400);
        }
    }

    public function show(Publicaciones $publicacion, Request $request){
        try{
            $publicacion->files->map(function($file){
                $file->path = Storage::url($file->path);
                return $file;
            });
            $publicacion->miniatura_path = Storage::url($publicacion->miniatura_path);
            Logs::create([
                'tipo_log_id' => 4,
                'descripcion' => 'Obtener articulo,'.$publicacion->id,
                'ip' => $request->ip()
            ]);
            return response()->json([
                'status' => true,
                'publicacion' => $publicacion
            ],200);

        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al obtener el articulo'
            ],400);
        }
    }


    public function update(Request $request){

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
            $publicacion = Publicaciones::find($data->id);
            Files::where('publicacion_id', $publicacion->id)->delete();
            Storage::deleteDirectory('public/articulo/'.$publicacion->id);
            $fecha_creacion = Carbon::parse($data->fecha_creacion);

            $publicacion->titulo = $data->titulo;
            $publicacion->descripcion = $data->descripcion;
            $publicacion->fecha_creacion = $fecha_creacion;
            $publicacion->user_id = $data->user_id;
            $publicacion->contenido = $data->contenido;
            $publicacion->miniatura_path = '';
            $publicacion->save();
            $files = $request->allFiles();
            if (true) {
                foreach($files as $file){
                    $extension =  $file->getClientOriginalExtension();
                    $path = "";
                    $miniaturaPath = "";
                    $fileName = $file->getClientOriginalName();
                    if($extension == 'glb' || $extension == 'gltf'){
                        $path = $file->storeAs('public/articulo/'.$publicacion->id.'/model', $file->getClientOriginalName());
                    }else if($file == $request->file('miniatura')){
                        $miniaturaPath = $file->storeAs('public/articulo/'.$publicacion->id.'/img', 'minuatura_'.$publicacion->id.'.'.$extension);
                        $path = $miniaturaPath;
                    }else{
                        $path = $file->storeAs('public/articulo/'.$publicacion->id.'/img', $file->getClientOriginalName());
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
            Logs::create([
                'tipo_log_id' => 7,
                'descripcion' => 'Se ha actualizado un articulo',
                'ip' => $request->ip()
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Articulo Actualizado con exito'
            ],200);


        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al actualizar el articulo'
            ],400);
        }
    }


}
