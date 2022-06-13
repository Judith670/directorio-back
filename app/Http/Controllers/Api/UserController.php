<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Company;
use App\Models\UserCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // public function register(StoreUserRequest $request){

    //     $user = new User($request->all());
    //     $user->save();

    //     if($request->has('company_name')){
    //         $company = new Company;
    //         $company->company_name = $request->input('company_name');
    //         $company->category = $request->input('category');
    //         $company->save();

    //         $user_company = new UserCompany;
    //         $user_company->id_user = $user->id;
    //         $user_company->id_company = $company->id;
    //         $user_company->save();
    //     }

    //     return response()->json([
    //         "status" => 1,
    //         "message" => "!Registro de usuario exitoso¡"
    //     ],200);
    // }

    // public function login(Request $request){
    //     $request->validate([
    //         "email" => "required|email",
    //         "password" => "required"
    //     ]);
    //     $user = User::where("email", "=", $request->email)->first();
    //     if( isset($user->id)){
    //         if(Hash::check($request->password, $user->password)){
    //             $token = $user->createToken("auth_token")->plainTextToken;
    //             return response()->json([
    //                 "status" => 1,
    //                 "message" => "Inicio de sesion correcto",
    //                 "access_token" => $token
    //             ],200);
    //         }else{
    //             return response()->json([
    //                 "status" => 0,
    //                 "message" => "Contraseña incorrecta"
    //             ], 401);
    //         }
    //     }else{
    //         return response()->json([
    //             "status" => 0,
    //             "message" => "Correo no registrado"
    //         ], 401);
    //     }
    // }

    // public function userProfile(){
    //     return response()->json([
    //         "status" => 1   ,
    //         "message" => "Informacion de usuario",
    //         "data" => auth()->user()
    //     ], 202);
    // }

    // public function logout(){
    //     auth()->user()->tokens()->delete();
    //     return response()->json([
    //         "status" => 1,
    //         "message" => "Logout"
    //     ], 200);
    // }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();
        return response()->json($usuarios,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $usuario = User::create($request->all());
        return response()->json([
            'message' => 'Usuarios registrado',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = User::findOrFail($id);
        return response()->json([
            $usuario
        ],200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $usuario = User::findOrFail($id);
        $usuario->update($request->all());
        return response()->json([
            'message' => 'Usuario actualizado',
            'usuario' => $usuario,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();
        return response()->json([
            'message' => 'Usuario eliminad',
        ], 201);
    }
}
