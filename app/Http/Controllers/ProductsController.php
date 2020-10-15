<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Products;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return response()->json(Products::get());
       //  $product = Auth::user()->products;
        $product = Products::get();
        return  response()->json([
            'success' => true,
            'data' => $product,
        ] , 200); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       /*  $rules =  [
            'name' => 'required|min:3|max:20'


         ];
          $validator = Validator::make($request->all(), $rules);
          if($validator->fails()){
               return response()->json($validator->errors(), 400);
          }   

          $tes = Products::create($request->all());
          return response()->json($tes , 201); */
      /*     $this->validate($request,[
              'name' => 'required|min:3|max:20',
              'stock' => 'required|min:0',
              'precio_actual' => 'required|integer'
          ]);
       
        $product = new Products();
        $product->name = $request->name;
        $product->stock = $request->stock;
        $product->precio_actual = $request->precio_actual;

        $product->save();

        if($user->save($product)){
            return  response()->json([
                'success' => true,
                'data' => $product->toArray(),
            ], 200);
        }else{
            return  response()->json([
                'success' => false,
                'data' => 'El producto no se ha podido guardar',
            ], 500);
        } */

        $product = $request->only('name','category_id','stock','precio_actual');
        $validate = Validator::make($product ,[
               'name' => 'required|min:3|max:25',
               'category_id' => 'required',
               'stock' => 'required',
               'precio_actual' => 'required'
        ]);
        if(!$validate->fails()){
            $productToSave = new Products();
            $productToSave->name = $request->name;
            $productToSave->category_id = $request->category_id;
            $productToSave->stock = $request->stock;
            $productToSave->precio_actual = $request->precio_actual;
            $productToSave->save();

            return response()->json([
                'sucess' => true,
                'data' => $productToSave
            ], 200);
        }else{
            return response()->json([
                'sucess' => true,
                'error' => $validate->errors(),
                'data' => 'No se ha podido guardar el producto'
             ], 500);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       /*  $test = Products::find($id);
        if(is_null($test)){
            return response()->json(["mensaje" => "Este registro no ha sido encontrado"], 404);
        }
       return response()->json($test , 200); */
   
       $product = Products::find($id);

       if(!$product){
           return response()->json([
              'success' => false,
              'data' => 'El producto con el id '. $id .' no existe',
           ], 400);  
       }
       return response()->json([
            'success' => true,
            'data' => $product,
       ], 200);
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
        /* $test = Products::find($id);
        if(is_null($test)){
             return response()->json(["mensaje" => "El registro que intentas actualizar no ha sido encontrado"], 404);
         }
        $test->update($request->all());
        return response()->json($test, 200); */
        $product = Products::find($id);
        $productToUpdate = $request->only('name');

        $validate = Validator::make($productToUpdate, [
             'name' => 'min:3|max:25', 
        ]);

        if($validate->fails()){
             return response()->json([
                 'success' => false,
                 'error' => $validate->errors(),
                  'data' => 'El campo del nombre no puede quedar vacio'
             ]);
        }

        if(!$product){
            return response()->json([
                'success' => false,
                'data' => 'El producto con el id '. $id .' no existe',
             ], 400); 
        }

        $updated = $product->fill($request->all())->save();

        if(!$updated){
            return response()->json([
                'success' => false,
                'data' => 'No se ha podido actualizar el registro',
             ], 500); 
        }else{
            return response()->json([
                'success' => true,
                'data' => 'Se ha actualizado el registro',
             ], 200); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       /*  $test = Products::find($id);
        if(is_null($test)){
            return response()->json(["mensaje" => "El registro que intesentas eliminar no ha sido encontrado"], 404);
        }
        $test->delete();
        return response()->json('Registro Eliminado' , 200); */

        $product = Products::find($id);
        if(!$product){
            return response()->json([
                'success' => false,
                'data' => 'El producto con el id '. $id . ' no existe',
             ], 400); 
        }

        if($product->delete()){
            return response()->json([
                'success' => true,
                'data' => 'Se ha eliminado el producto',
             ], 200);
        }else{
            return response()->json([
                'success' => false,
                'data' => 'No se ha podido eliminar el producto',
             ], 500);
        }

    }
}
