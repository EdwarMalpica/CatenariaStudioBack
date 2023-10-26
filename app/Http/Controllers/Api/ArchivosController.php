<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Files;
use App\Models\EstadoCita;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArchivosController extends Controller
{
    public function upload(Request $request) {
        try{
            $request->validate([
             'archivo' => 'required|file|mimetypes:application/json,model/gltf-binary,model/gltf+json'
            ]);

            if ($request->file('archivo')->isValid()) {
                $archivo = $request->file('archivo');
                $nombreArchivo = $archivo->getClientOriginalName();
                $extension = $archivo->getClientOriginalExtension();
                $nombreUnico = Str::uuid()->toString() . '.' . $extension;
                $ruta = $archivo->storeAs('archivos_modelos', $nombreUnico);

                $user = auth()->user();
                Files::create([
                'nombre' => $nombreArchivo,
                'path' => $ruta,
                'user_id' => $user->id,
                'formato' => $extension
                ]);
            
               return response()->json(['mensaje' => 'Archivo cargado con éxito ' . $nombreUnico]);
            }
        }catch(Exception $e){
               return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al cargar el archivo'
              ],400);
        }
    }
}
