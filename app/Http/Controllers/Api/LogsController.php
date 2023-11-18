<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Citas;
use App\Models\Logs;
use App\Models\Publicaciones;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index(){
        try{
            return response()->json([
                'status' => true,
                'logs' => Logs::all()
            ],200);
        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al obtener los logs'
            ],400);
        }
    }
    public function storeVisit(){
        try{
            Logs::create([
                'tipo_log_id' => 6,
                'descripcion' => 'Visita a la pagina',
                'ip' => request()->ip()
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Log creado'
            ],200);
        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al crear el log'
            ],400);
        }
    }
    public function LogsUserActions(){
        try{
            $visitToThePage = Logs::where('tipo_log_id', 6)->get()->count();
            $visitToThePageLastMonth = Logs::where('tipo_log_id', 6)->whereMonth('created_at', date('m'))->get()->count();
            $visitToThePageThisWeek = Logs::where('tipo_log_id', 6)->whereBetween('created_at', [date('Y-m-d', strtotime('monday this week')), date('Y-m-d', strtotime('sunday this week'))])->get()->count();
            $visitToThePageLastYear = Logs::where('tipo_log_id', 6)->whereYear('created_at', date('Y'))->get()->count();
            $visitToThePagePenultimateMonth = Logs::where('tipo_log_id', 6)->whereMonth('created_at', date('m')-2)->get()->count();
            $visitToThePageForLast12Month = [];
            $increaseInVisitToThePageLastMonth = 0;

            if ($visitToThePagePenultimateMonth == 0) {
                $increaseInVisitToThePageLastMonth = 1;
            }else{
                $increaseInVisitToThePageLastMonth = ($visitToThePageLastMonth/ $visitToThePagePenultimateMonth)*100;
            }



            for ($i = 0; $i <= 11; $i++) {
                $mes = Carbon::now()->subMonths($i)->locale('es')->monthName;
                $numeroDePersonas = Logs::where('tipo_log_id', 6)
                    ->whereMonth('created_at', date('m') - $i)
                    ->count();

                $registro = [
                    'mes' => $mes,
                    'valor' => $numeroDePersonas
                ];

                $visitToThePageForLast12Month[] = $registro;
            }


            $loginUsers = Logs::where('tipo_log_id', 1)->get()->count();
            $registerUsers = Logs::where('tipo_log_id', 2)->get()->count();
            $registerUsersLastMonth = Logs::where('tipo_log_id', 2)->whereMonth('created_at', date('m'))->get()->count();
            $registerUsersThisWeek = Logs::where('tipo_log_id', 2)->whereBetween('created_at', [date('Y-m-d', strtotime('monday this week')), date('Y-m-d', strtotime('sunday this week'))])->get()->count();
            $registerUsersLastYear = Logs::where('tipo_log_id', 2)->whereYear('created_at', date('Y'))->get()->count();
            $registerUsersPenultimateMonth = Logs::where('tipo_log_id', 2)->whereMonth('created_at', date('m')-2)->get()->count();
            $registerUsersForLast12Month = [];
            $increaseInRegisterUsersLastMonth = 0;

            if ($registerUsersPenultimateMonth == 0) {
                $increaseInRegisterUsersLastMonth = 1;
            }else{
                $increaseInRegisterUsersLastMonth = ($registerUsersLastMonth/ $registerUsersPenultimateMonth)*100;
            }

            for ($i = 0; $i <= 11; $i++) {
                $mes = Carbon::now()->subMonths($i)->locale('es')->monthName;
                $numeroDePersonas = Logs::where('tipo_log_id', 2)
                    ->whereMonth('created_at', date('m') - $i)
                    ->count();

                $registro = [
                    'mes' => $mes,
                    'valor' => $numeroDePersonas
                ];

                $registerUsersForLast12Month[] = $registro;
            }
            if ($registerUsersPenultimateMonth == 0) {
                $increaseInRegisterUsersLastMonth = 1;
            }else{
                $increaseInRegisterUsersLastMonth = ($registerUsersLastMonth/ $registerUsersPenultimateMonth)*100;

            }
            $loginUsers = Logs::where('tipo_log_id', 1)->get()->count();
            $loginUsersLastMonth = Logs::where('tipo_log_id', 1)->whereMonth('created_at', date('m'))->get()->count();
            $loginUsersThisWeek = Logs::where('tipo_log_id', 1)->whereBetween('created_at', [date('Y-m-d', strtotime('monday this week')), date('Y-m-d', strtotime('sunday this week'))])->get()->count();
            $loginUsersLastYear = Logs::where('tipo_log_id', 1)->whereYear('created_at', date('Y'))->get()->count();
            $loginUsersPenultimateMonth = Logs::where('tipo_log_id', 1)->whereMonth('created_at', date('m')-2)->get()->count();
            $loginUsersForLast12Month = [];

            for ($i = 0; $i <= 11; $i++) {
                $mes = Carbon::now()->subMonths($i)->locale('es')->monthName;
                $numeroDePersonas = Logs::where('tipo_log_id', 1)
                    ->whereMonth('created_at', date('m') - $i)
                    ->count();

                $registro = [
                    'mes' => $mes,
                    'valor' => $numeroDePersonas
                ];

                $loginUsersForLast12Month[] = $registro;
            }
            return response()->json([
                'status' => true,
                'visitToThePage' => $visitToThePage,
                'visitToThePageLastMonth' => $visitToThePageLastMonth,
                'visitToThePageThisWeek' => $visitToThePageThisWeek,
                'visitToThePageLastYear' => $visitToThePageLastYear,
                'visitToThePageForLast12Month' => $visitToThePageForLast12Month,
                'increaseInVisitToThePageLastMonth' => $increaseInVisitToThePageLastMonth,
                'loginUsers' => $loginUsers,
                'loginUsersLastMonth' => $loginUsersLastMonth,
                'loginUsersThisWeek' => $loginUsersThisWeek,
                'loginUsersLastYear' => $loginUsersLastYear,
                'loginUsersForLast12Month' => $loginUsersForLast12Month,
                'registerUsers' => $registerUsers,
                'registerUsersLastMonth' => $registerUsersLastMonth,
                'registerUsersThisWeek' => $registerUsersThisWeek,
                'registerUsersLastYear' => $registerUsersLastYear,
                'registerUsersForLast12Month' => $registerUsersForLast12Month,
                'increaseInRegisterUsersLastMonth' => $increaseInRegisterUsersLastMonth
            ],200);
        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al obtener los logs'
            ],400);
        }
    }

    public function LogsProyectsActions(){
        try{
            $proyects = Logs::where('tipo_log_id', 3)->get();
            $visitToProyectsLastMonth = Logs::where('tipo_log_id', 3)->whereMonth('created_at', date('m'))->get()->count();
            $visitToProyectsThisWeek = Logs::where('tipo_log_id', 3)->whereBetween('created_at', [date('Y-m-d', strtotime('monday this week')), date('Y-m-d', strtotime('sunday this week'))])->get()->count();
            $visitToProyectsLastYear = Logs::where('tipo_log_id', 3)->whereYear('created_at', date('Y'))->get()->count();
            $visitToProyectsPenultimateMonth = Logs::where('tipo_log_id', 3)->whereMonth('created_at', date('m')-2)->get()->count();
            $visitToProyectsForLast12Month = [];
            $increaseInProyectsLastMonth = 0;

            $projectVisits = [];
            foreach ($proyects as $log) {
                $parts = explode(',', $log->descripcion);

                $projectId = $parts[1];

                if (!isset($projectVisits[$projectId])) {
                    $projectVisits[$projectId] = 0;
                }

                $projectVisits[$projectId]++;
            }

            arsort($projectVisits);

            $topProjects = [];

            foreach ($projectVisits as $projectId => $visits) {
                $project = Publicaciones::find($projectId);
                if ($project) {
                    $topProjects[] = [
                        'project' => $project->titulo,
                        'visits' => $visits
                    ];
                }
            }

            if ($visitToProyectsPenultimateMonth == 0) {
                $increaseInProyectsLastMonth = 1;
            }else{
                $increaseInProyectsLastMonth = ($visitToProyectsLastMonth/ $visitToProyectsPenultimateMonth)*100;
            }

            for ($i = 0; $i <= 11; $i++) {
                $mes = Carbon::now()->subMonths($i)->locale('es')->monthName;
                $numeroDeVisitas = Logs::where('tipo_log_id', 3)
                    ->whereMonth('created_at', date('m') - $i)
                    ->count();

                $registro = [
                    'mes' => $mes,
                    'valor' => $numeroDeVisitas
                ];

                $visitToProyectsForLast12Month[] = $registro;
            }
           return response()->json([
                'status' => true,
                'proyects' => Publicaciones::where('tipo_publicacion_id',1)->count(),
                'visitToAllProyects' => $proyects->count(),
                'visitToProyectsLastMonth' => $visitToProyectsLastMonth,
                'visitToProyectsThisWeek' => $visitToProyectsThisWeek,
                'visitToProyectsLastYear' => $visitToProyectsLastYear,
                'visitToProyectsForLast12Month' => $visitToProyectsForLast12Month,
                'increaseInProyectsLastMonth' => $increaseInProyectsLastMonth,
                'mostVisitedProyects' => $topProjects
            ],200);
        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al obtener los logs'
            ],400);
        }
    }
    public function LogsArticlesActions(){

        try{
            $articles = Logs::where('tipo_log_id', 4)->get();
            $visitToArticlesLastMonth = Logs::where('tipo_log_id', 4)->whereMonth('created_at', date('m'))->get()->count();
            $visitToArticlesThisWeek = Logs::where('tipo_log_id', 4)->whereBetween('created_at', [date('Y-m-d', strtotime('monday this week')), date('Y-m-d', strtotime('sunday this week'))])->get()->count();
            $visitToArticlesLastYear = Logs::where('tipo_log_id', 4)->whereYear('created_at', date('Y'))->get()->count();
            $visitToArticlesPenultimateMonth = Logs::where('tipo_log_id', 4)->whereMonth('created_at', date('m')-2)->get()->count();
            $visitToArticlesForLast12Month = [];
            $increaseInArticlesLastMonth = 0;

            $articleVisits = [];
            foreach ($articles as $log) {
                $parts = explode(',', $log->descripcion);

                $articleId = $parts[1];

                if (!isset($articleVisits[$articleId])) {
                    $articleVisits[$articleId] = 0;
                }

                $articleVisits[$articleId]++;
            }

            arsort($articleVisits);

            $topArticles = [];

            foreach ($articleVisits as $articleId => $visits) {
                $article = Publicaciones::find($articleId);
                if ($article) {
                    $topArticles[] = [
                        'article' => $article->titulo,
                        'visits' => $visits
                    ];
                }
            }

            if ($visitToArticlesPenultimateMonth == 0) {
                $increaseInArticlesLastMonth = 1;
            }else{
                $increaseInArticlesLastMonth = ($visitToArticlesLastMonth/ $visitToArticlesPenultimateMonth)*100;
            }

            for ($i = 0; $i <= 11; $i++) {
                $mes = Carbon::now()->subMonths($i)->locale('es')->monthName;
                $numeroDeVisitas = Logs::where('tipo_log_id', 4)
                    ->whereMonth('created_at', date('m') - $i)
                    ->count();

                $registro = [
                    'mes' => $mes,
                    'valor' => $numeroDeVisitas
                ];

                $visitToArticlesForLast12Month[] = $registro;
            }
            return response()->json([
                'status' => true,
                'articles' => Publicaciones::where('tipo_publicacion_id',2)->count(),
                'visitToAllArticles' => $articles->count(),
                'visitToArticlesLastMonth' => $visitToArticlesLastMonth,
                'visitToArticlesThisWeek' => $visitToArticlesThisWeek,
                'visitToArticlesLastYear' => $visitToArticlesLastYear,
                'visitToArticlesForLast12Month' => $visitToArticlesForLast12Month,
                'increaseInArticlesLastMonth' => $increaseInArticlesLastMonth,
                'mostVisitedArticles' => $topArticles
            ],200);
        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al obtener los logs'
            ],400);
        }
    }

    public function LogsCitasActions(){
        try{
            $citas = Logs::where('tipo_log_id', 5)->get();
            $citasLastMonth = Logs::where('tipo_log_id', 5)->whereMonth('created_at', date('m'))->get()->count();
            $citasThisWeek = Logs::where('tipo_log_id', 5)->whereBetween('created_at', [date('Y-m-d', strtotime('monday this week')), date('Y-m-d', strtotime('sunday this week'))])->get()->count();
            $citasLastYear = Logs::where('tipo_log_id', 5)->whereYear('created_at', date('Y'))->get()->count();
            $citasPenultimateMonth = Logs::where('tipo_log_id', 5)->whereMonth('created_at', date('m')-2)->get()->count();
            $citasForLast12Month = [];
            $increaseInCitasLastMonth = 0;

            if ($citasPenultimateMonth == 0) {
                $increaseInCitasLastMonth = 1;
            }else{
                $increaseInCitasLastMonth = ($citasLastMonth/ $citasPenultimateMonth)*100;
            }

            for ($i = 0; $i <= 11; $i++) {
                $mes = Carbon::now()->subMonths($i)->locale('es')->monthName;
                $numeroDeVisitas = Logs::where('tipo_log_id', 5)
                    ->whereMonth('created_at', date('m') - $i)
                    ->count();

                $registro = [
                    'mes' => $mes,
                    'valor' => $numeroDeVisitas
                ];

                $citasForLast12Month[] = $registro;
            }
            return response()->json([
                'status' => true,
                'citas' => Citas::all()->count(),
                'visitToAllCitas' => $citas->count(),
                'citasLastMonth' => $citasLastMonth,
                'citasThisWeek' => $citasThisWeek,
                'citasLastYear' => $citasLastYear,
                'citasForLast12Month' => $citasForLast12Month,
                'increaseInCitasLastMonth' => $increaseInCitasLastMonth,
            ],200);
        }catch(Exception $e){
            return response()->json([
                'errors' => $e->getMessage(),
                'status' => false,
                'message' => 'Error al obtener los logs'
            ],400);
        }
    }
}
