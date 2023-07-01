<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Http\Requests\AppRequest;
use App\Jobs\BuildApp;
use App\Jobs\CheckLog;
use Illuminate\Http\Request;
use App\Models\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Spatie\Async\Pool;

class AppsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $data = App::when(($request->input("searchString") != ""), function ($q) use ($request) {
            $q
                ->orWhere("name", "like", "%" . $request->searchString . "%");
        })->when(($request->input("name") != ""), function ($q) use ($request) {
                $q->where("name", "like", "%" . $request->name . "%");
            })->paginate($perPage);

        return ApiResponseController::response('Consulta Exitosa', 200, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppRequest $request)
    {
        $app = new App();

        $app->name = $request->name;

        $formatedAppName = str_replace(" ", "-", $app->name);
        $formatedAppName = strtolower($formatedAppName);

        $app->code = $formatedAppName;
        $app->save();



        // shell_exec("sh C:/laragon/www/apps-management/base/build-app.bash ". $formatedAppName);

        return ApiResponseController::response('Registro creado con exito', 200);
    }

    public function abort(Request $request)
    {
        session(['cancelScript' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $app = App::find($id);

        if (!$app) {
            return ApiResponseController::response('No se encontro el registro', 204, null);
        }

        return ApiResponseController::response('Consulta Exitosa', 200, $app);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AppRequest $request, $id)
    {
        $app = App::find($id);

        if (!$app) {
            return ApiResponseController::response('No se encontro el registro', 204, null);
        }

        $app->name = $request->name;

        // Lowercase and snakecase
        $appName = strtolower($app->name);
        $appName = str_replace(' ', '-', $app->name);


        $app->save();

        BuildApp::dispatch($appName);

        return ApiResponseController::response('Registro actualizado con exito', 200, $app);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $app = App::find($id);

        if (!$app) {
            return ApiResponseController::response('No se encontro el registro', 204, null);
        }

        $app->delete();
        return ApiResponseController::response('Registro eliminada con exito', 200, null);
    }


    public function getAll()
    {
        $data = App::all();
        return ApiResponseController::response('Consulta Exitosa', 200, $data);
    }

    public function buildApp($appName = '')
    {
        $pool = Pool::create();

        $scriptPath = 'C:/laragon/www/apps-management/base/build-app.bash';
        $logPath = 'C:/laragon/www/apps-management/base/log';

        $output = shell_exec("sh C:/laragon/www/apps-management/base/build-app.bash $appName");

        return $output;
    }


    public function checkLog() {

        CheckLog::dispatch();
        return ApiResponseController::response('Checkeando', 200);
    }
}
