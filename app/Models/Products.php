<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Products extends Model
{
    use HasFactory;
    protected $table = "products";
   // public $user_id = false;
    //public $precio_anterior = false;
   // public $descuento = false;
   // public $timestamps = false;

    protected $fillable =[
        'id',
       // 'category_id',
        'name',
        'stock',
        'precio_actual',
        'precio_anterior',
        'descuento',

    ];


    public function category(){
        return $this->belongsTo(Category::class);
    }
}
