<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriesModel;

class Categories extends Controller
{
    public function categories(){
        return response()->json(CategoriesModel::all());
    }

    /* public function index(){
        $datos = CategoriesModel::all();
        return $datos;
      
    
    } */

}
