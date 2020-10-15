<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

//use Illuminate\Support\Facades\JWTAuth;

class PassportController extends Controller
{

    //public  $loginAfterSignUp = true;

    public function register(Request $request){

            $credentials = $request->only('name','roll' , 'email', 'password');

            $validate = Validator::make($credentials, [
                 'name' => 'required|min:3|max:15',
                 'roll' => 'required',
                 'email' => 'required|email|unique:users',
                 'password' => 'required|min:8'
            ]);

            if($validate->fails()){
                return response()->json([
                   'success' => false,
                    'data' => $validate->errors()
                ],400);
            }else{

                

                $user = new User();
                $user->name = $request->name;
                $user->roll = $request->roll;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->save();

              
                $token = JWTAuth::attempt($credentials);

              if($token){
                   return response()->json([
                        'success' => true,
                        'token' => compact('token') ,
                        'data' => 'Usuario Creado'
                    ], 200);
                }else{
                    return response()->json([
                        'success' => false,
                        'data' => 'NO se ha podido guardar el usuario'
                    ], 500);
                }
          
         
               
           } 

          // return response()->json(['mensaje' => 'OK']);
           
                        
    }

    public function login(Request $request){
         /*  $credentials =[
              'email' => $request->email,
              'password' => $request->password,
          ];

          if(Auth::attempt($credentials) ){
                $authenticated_user = Auth::user();
                $user = User::find($authenticated_user->id);
                $token = $user->createToken('MYSECRETTOKEN')->accessToken;
                return response()->json(['token' => $token] , 200);
            }else{
                 return response()->json(['error' => 'UnAuthorized'] , 401);
            }  */
            $credentials = $request->only('email', 'password');
            $validate = Validator::make($credentials ,[
                'email' =>  'required',
                'password' => 'required',
            ]);

            if($validate->fails()){
                return response()->json([
                    'success' =>  false,
                    'data' => $validate->errors(),
                ], 400);

            }else{
                try {
                    if(!$token = JWTAuth::attempt($credentials)){
                        return response()->json([
                            'success' => false,
                            'data' => 'UnAthorized'
                        ], 401);
                    }
                } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
                    return response()->json([
                        'success' => false,
                        'data' =>  $e->getMessage(),
                    ], 401);
                }

                return response()->json([
                    'success' => true,
                    'token' => compact('token') ,
                    'data' => 'Credenciales Correctas'
                ], 200);

            }
       
    }

    public function Users(){
        $user = User::get();
        return response()->json([
               'success' => true,
               'users' => $user
            ] , 200);
    }

    public function DeleteUser($id){
       $user = User::find($id);
       if(!$user){
           return response()->json([
               'success' => false,
               'data' => 'El usuario con el id '. $id . ' no existe',
           ], 400);
       }else{
            $user->delete();
            return response()->json([
                'success' => true,
                'data' => 'Usuario Eliminado'
            ], 200);
       }
    }

    public function UpdateUser(Request $request, $id){
          $user = User::find($id);
          $credentials = $request->only('name','email','password');

          if(!$user){
                return response()->json([
                    'success' => false,
                    'data' => 'El usuario con el id '. $id . ' no existe',
                ], 400);
          }

          $validate = Validator::make($credentials,[
               'name' => 'min:3|max:15',
               'email' => 'email',
               'password' => 'min:8'
          ]);
          if($validate->fails()){
              return response()->json([
                  'success' => false,
                  'error' => $validate->errors(),
                  
              ], 400);
          }else{
              $updateuser = $user->fill($request->all())->save();
              if($updateuser){
                    return response()->json([
                        'success' => true,
                        'error' => 'Se ha actualizado el usuario',
                    ], 200);
              }else{
                return response()->json([
                    'success' => false,
                    'error' =>'No se ha podido actualizar el registro',
                    
                ], 500);
              }
          }
     


    }







}
