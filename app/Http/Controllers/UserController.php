<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    //fungsi untuk mengatur register / create user
    public function registerUser(Request $request){
        
        //buat variable data yang berisi request (name, email, password)
        $data = $request->only(['name', 'email', 'password']);

        //validasi data dari user input
        $validator = Validator::make(
            $data,
            [
                'name' => 'required|string|max:100',
                'email' => 'required|string|email',
                'password' => 'required|string|min:6'
            ]
        );

        //jika validatornya gagal maka muncul error
        if($validator->fails()){
            $errors = $validator->errors();
            return response()->json(compact('errors'), 401);
        }

        //buat user sesuai $data tersebut
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        //menampilkan response berisi user dan token
        //200 artinya sukses
        return response()->json(compact('user'), 200);
    }

    //Fungsi login user 
    public function loginUser(Request $request){
        //Mencari user dari inputan user menggunakan email
        $user = User::where('email', 
        
        $request['email'])->first();

        //Auth attempt untuk mengecek apakah data(email dan password) sesuai
        if($user&&Hash::check($request->password,
        $user->password)){
            //membuat token
            $token = Str::random(60);
            $user->remember_token = $token;
            $user->save();
            
            return response()->json([
                "status"=>200,
                "message"=>"success",  
                "token"=>$token,
                "user"=>$user
            ],200);
        } 
        return response()->json([
            "status"=>401,
            "message"=>"failed",
        ],401);
    
    }

    //fungsi logout, menghapus token dari database
    public function logoutUser(Request $request){
        //mencari user menggunakan token 
        $user = User::where('remember_token', 
        $request->bearerToken())->first();

        //kalo user ada, jadiin token itu null
        if($user){
            $user->remember_token = null;
            $user->save();
            return response()->json([
                "status"=>200,
                "message"=>"success",
            ],200);
        }  
        return response()->json([
            "status"=>401,
            "message"=>"failed",
        ],401);
    }

    //fungsi untuk mendapatkan data user / read user
    public function getUser($id){
        $user = User::find($id);
        return response()->json(compact('user'), 200);
    }

    //fungsi untuk mengubah data user / update user
    //parameternya adalah id dari user yang akan diubah dan request berisi input user
    public function updateUser($id, Request $request){
        $user = User::find($id);
        $input = $request->all();

        if(isset($request->name)){
            $user->name = $input['name'];
        }

        if(isset($request->email)){
            $user->email = $input['email'];
        }
        
        if(isset($passwordd)){
            $user->password = Hash::make($input['password']);
        }
        
        //save ke database
        $user->save();

        return response()->json(compact('user'), 200);
    }
    
    //fungsi untuk menghapus user / delete user
    public function deleteUser($id){
        $user = User::find($id);
        $result = $user->delete();
        return response()->json(compact('result'), 200);
    }
}