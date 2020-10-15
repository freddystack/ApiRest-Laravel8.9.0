<?php

namespace App\Http\Controllers;

use App\Models\test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $data = test::all();
            return $data;
    }

    public function all()
    {
        return response()->json(test::get());
           /*  $data = test::all();
            return $data; */
    }

    public function GetOne($id){
      $test = test::find($id);
      if(is_null($test)){
        return response()->json(["mensaje" => "Este registro no ha sido encontrado"], 404);
      }
       return response()->json($test , 200);
       
    }

    public function createTest(Request $request) {
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

    public function updateTest(Request $request , $id){
        $test = test::find($id);
        if(is_null($test)){
             return response()->json(["mensaje" => "El registro que intentas actualizar no ha sido encontrado"], 404);
         }
        $test->update($request->all());
        return response()->json($test, 200);
    }

    public function deleteTest(Request $request, $id){
        $test = test::find($id);
        if(is_null($test)){
            return response()->json(["mensaje" => "El registro que intesentas eliminar no ha sido encontrado"], 404);
        }
        $test->delete();
        return response()->json('Registro Eliminado' , 200);
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
       $data = test::create($request->all());
       return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(test $test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, test $test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(test $test)
    {
        //
    }
}
