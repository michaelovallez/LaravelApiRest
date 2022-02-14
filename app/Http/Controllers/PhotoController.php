<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 1800);  //extension de tiempo de ejecucion para cargar datos desde api externa en la db.

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use App\Models\Photo;
use Illuminate\Support\Facades\DB;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        /**
         * Este metodo realiza una peticion http a un endpoint. 
         * comprueba estado de conexion,
         * almacena los registros en la DB.
         * A modo de prueba, devuelve mediante una api, el contenido de la tabla photos para ser visualizado
         * con los datos ya cargados.
         */
        $response = Http::retry(3, 100, function ($exception) {      //Conexion API externa. realiza 3 intentos de conexion cada 100 milisegundos. 
            return $exception instanceof ConnectionException;
        })->get('https://jsonplaceholder.typicode.com/photos');
        if ($response->status()==200)
        {
            $photos = $response->json();                //Respuesta convertida en Json y se almacena en una variable.
            

            $isAccessible = Arr::accessible($photos);   //Consulta si es un array accesible para recorrer
            foreach ($photos as $photo)                 //Recorrer cada elemento del array
            {
                DB::table('photos')->insert([           //Carga de datos en tabla 'photos'. 
                    'albumId' => $photo["albumId"],
                    'title' => $photo["title"],
                    'url' => $photo["url"],
                    'thumbnailUrl' => $photo["thumbnailUrl"]
                ]);
            }
            
            try {
                $photos = DB::table('photos')->paginate(2); //Consulta a DB para retornar contenido de tabla 'photos', cargada con datos de api externa
                
            } catch (ModelNotFoundException $exception) {      //control de exepciones
                return back()->withError($exception->getMessage())->withInput();
            }
            return response()->json($photos,status:200); //retorna json con datos de la tabla y status
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
