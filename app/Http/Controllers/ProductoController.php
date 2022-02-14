<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ProductoRequest;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
     
    public function index()
    {
        /**
      * Metodo index devuelve por metodo GET contenido de la tabla PRODUCTOS, con paginacion de 2 elementos
      * retornando los resultados de la busqueda, y status de conexion.
      */
        try {
            $productos = DB::table('productos')->paginate(2); 
            
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return response()->json($productos,status:200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductoRequest $request)
    {   
        /**
         * Metodo store carga nuevos elementos en la tabla producto, recibiendo parametros por POST.
         * Utiliza las reglas definidas en el archivo ProductoRequest, que permite devolver un mensaje
         * indicando el error producido al intentar insertar datos que no correspondan
         * Devuelve un mensaje con el resultado de la carga y la respuesta.
         * status http indicando correcta conexion y que se creo un nuevo recurso.
         */
        try {
        Producto::create($request->all());
    
        return response()->json([
            'res'=>true,
            'msg'=> 'Producto Cargado Correctamente',
            'status'=> 201

        ],status:201);
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        /**
         * Metodo show, recibe mediante GET el nombre de un producto para buscar en la tabla PRODUCTOS
         * con un paginado de 6 elementos, devuelve un json con el contenido de la peticion a la db
         * y el estado de conexion http.
         */
        try {
            $productos = DB::table('productos')->where('name', $name)->paginate(6); //Producto::all()->paginate(2);
            return response()->json($productos,status:200);
            
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
            
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
    public function update(ProductoRequest $request)
    {   
        /**
         * Metodo update, recibe parametros mediante PUT, luego actualiza el registro correspondiente al id recibido
         * devuelve un json con el contenido actualizado de dicho registro, un mensaje sobre el resultado y el estado de la conexion http. 
         */
        try {
        $producto = Producto::findOrFail($request->id);
        $producto->name = $request->name;
        $producto->description = $request->description;
        $producto->image = $request->image;
        $producto->brand = $request->brand;
        $producto->price = $request->price;
        $producto->price_sale = $request->price_sale;
        $producto->category = $request->category;
        $producto->stock = $request->stock;
        $producto->save();
        return response()->json([
            'res'=>true,
            'data'=>$producto,
            'msg'=> 'Producto Actualizado Correctamente',
            'status'=> 201
        ],status:201);
    } 
        catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $request)
    {
        /**
         * Metodo destroy, recibe id mediante DELETE, elimina el registro correspondiente a dicho id
         * devuelve un json con un mensaje con el resultado de la operacion el estado de la conexion http. 
         */
        try {
        $producto = Producto::destroy($request->id);
        return response()->json([
            'res'=>true,
            'msg'=> 'Producto Eliminado Correctamente',
            'status'=> 204
        ],status:204);
        } 
        catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
    }

    }
}
