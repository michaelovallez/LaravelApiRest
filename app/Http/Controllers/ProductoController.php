<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controller\Controller;
use App\Http\Requests\ProductoRequest;
use App\Models\Producto;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $productos = Producto::all();
            
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
    public function store(Request $request)
    {   
        
        
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'image' => 'required',
                'brand' => 'required',
                'price' => 'required',
                'price_sale' => 'required',
                'category' => 'required',
                'stock' => 'required',
              ]);
            $producto = new Producto();
            $producto->name = $request->name;
            $producto->description = $request->description;
            $producto->image = $request->image;
            $producto->brand = $request->brand;
            $producto->price = $request->price;
            $producto->price_sale = $request->price_sale;
            $producto->category = $request->category;
            $producto->stock = $request->stock;
            $producto->save();
        } 
        catch (ModelNotFoundException $exception) {
                return back()->withError($exception->getMessage())->withInput();
        }
        
        return response()->json($productos,status:201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $productos = Producto::where('name', $request->name);
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return response()->json($productos,status:404);
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
    public function update(Request $request)
    {   
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
    } 
        catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
    }
        return response()->json($producto,status:201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $request)
    {
        $producto = Producto::destroy($request->id);
        return response()->json($productos,status:204);
    }
}
