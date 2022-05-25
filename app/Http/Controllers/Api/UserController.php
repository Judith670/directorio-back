<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Models\Company;
use App\Models\UserCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(StoreUserRequest $request){

        $user = new User($request->all());
        $user->save();

        if($request->has('company_name')){
            $company = new Company;
            $company->company_name = $request->input('company_name');
            $company->category = $request->input('category');
            $company->save();

            $user_company = new UserCompany;
            $user_company->id_user = $user->id;
            $user_company->id_company = $company->id;
            $user_company->save();
        }

        return response()->json([
            "status" => 1,
            "message" => "!Registro de usuario exitoso¡"
        ],200);
    }

    public function login(Request $request){
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        $user = User::where("email", "=", $request->email)->first();
        if( isset($user->id)){
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken("auth_token")->plainTextToken;
                return response()->json([
                    "status" => 1,
                    "message" => "Inicio de sesion correcto",
                    "access_token" => $token
                ],200);
            }else{
                return response()->json([
                    "status" => 0,
                    "message" => "Contraseña incorrecta"
                ], 401);
            }
        }else{
            return response()->json([
                "status" => 0,
                "message" => "Correo no registrado"
            ], 401);
        }
    }

    public function userProfile(){
        return response()->json([
            "status" => 1   ,
            "message" => "Informacion de usuario",
            "data" => auth()->user()
        ], 202);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            "status" => 1,
            "message" => "Logout"
        ], 200);
    }

}
