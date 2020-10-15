<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\test;

class apiresource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(test::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules =  [
            'name' => 'required|min:3|max:10'

         ];
          $validator = Validator::make($request->all(), $rules);
          if($validator->fails()){
               return response()->json($validator->errors(), 400);
          }   

          $tes = test::create($request->all());
          return response()->json($tes , 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $test = test::find($id);
        if(is_null($test)){
            return response()->json(["mensaje" => "Este registro no ha sido encontrado"], 404);
        }
       return response()->json($test , 200);
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
        $test = test::find($id);
        if(is_null($test)){
             return response()->json(["mensaje" => "El registro que intentas actualizar no ha sido encontrado"], 404);
         }
        $test->update($request->all());
        return response()->json($test, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $test = test::find($id);
        if(is_null($test)){
            return response()->json(["mensaje" => "El registro que intesentas eliminar no ha sido encontrado"], 404);
        }
        $test->delete();
        return response()->json('Registro Eliminado' , 200);
    }
}
