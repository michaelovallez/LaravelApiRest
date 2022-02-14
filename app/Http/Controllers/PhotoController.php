<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 1800);

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
        $response = Http::retry(3, 100, function ($exception) {
            return $exception instanceof ConnectionException;
        })->get('https://jsonplaceholder.typicode.com/photos');
        if ($response->status()==200)
        {
            $photos = $response->json();
            

            $isAccessible = Arr::accessible($photos);
            foreach ($photos as $photo)
            {
                DB::table('photos')->insert([
                    'albumId' => $photo["albumId"],
                    'title' => $photo["title"],
                    'url' => $photo["url"],
                    'thumbnailUrl' => $photo["thumbnailUrl"]
                ]);
            }
            
            try {
                $photos = DB::table('photos')->paginate(2); //Producto::all()->paginate(2);
                
            } catch (ModelNotFoundException $exception) {
                return back()->withError($exception->getMessage())->withInput();
            }
            return response()->json($photos,status:200);
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
