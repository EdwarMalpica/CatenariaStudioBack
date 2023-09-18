<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //Obtener datos del usuario autenticado
    public function show(){
        try{
            $user = auth()->user();
            return response()->json([
                'status' => true,
                'user' => $user->detalle
            ]);
        }catch (\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
