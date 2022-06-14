<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth as JWT;

class TokensController extends Controller
{

    /**
     * Register user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(StoreUserRequest $request)
    {
        $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
        $token = JWT::fromUser($user);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            "access_token" => $token

        ], 201);
    }

    /**
     * login user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        $user = User::where("email", "=", $request->email)->first();
        try {
            // if (! $token = JWTAuth::fromUser($user)) {
            //     return response()->json(['error' => 'invalid_credentials'], 400);
            // }
            if( isset($user->id)){
                if(Hash::check($request->password, $user->password)){
                    // $token = $user->createToken("auth_token")->plainTextToken;
                    $token = JWT::fromUser($user);
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
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));


    }

    public function getAuthenticatedUser(Request $request)
    {
        //Validamos que la request tenga el token
        $this->validate($request, [
            'token' => 'required'
        ]);
        //Realizamos la autentificación
        $user = JWT::authenticate($request->token);
        //Si no hay usuario es que el token no es valido o que ha expirado
        if(!$user)
            return response()->json([
                'message' => 'Invalid token / token expired',
            ], 401);
        //Devolvemos los datos del usuario si todo va bien.
        return response()->json(['user' => $user]);
    }

    /**
     * Logout user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        // auth()->logout();
        $token = JWT::getToken();
        try {
            JWT::invalidate($token);
            return response()->json([
                'success' => true,
                'message' => 'Logout successful'
            ],200);
        } catch (JWTException $ex) {
            return response()->json([
                'sucess' => false,
                'message' => 'Failed logou, please try again'
            ],422);
        }
        // return response()->json(['message' => 'User successfully logged out.']);
    }

    /**
     * Refresh token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {

        $token = JWT::getToken();
        try{
            $token = JWT::refresh($token);
            return response()->json([
                'sucess' => true,
                'token' => $token

            ], 200);
        }catch (TokenExpiredException $ex){
            return response()->json([
                'sucess' => false,
                'message' => 'Volver a iniciar sesion !',
                // 'errors' => $validator->errors()
            ], 422);
        }catch (TokenBlacklistedException $ex){
            return response()->json([
                'sucess' => false,
                'message' => 'Volver a iniciar sesion !',
                // 'errors' => $validator->errors()
            ], 422);
        }
        // return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get user profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request): JsonResponse
    {
        //Validamos que la request tenga el token
        $this->validate($request, [
            'token' => 'required'
        ]);
        //Realizamos la autentificación
        $user = JWT::authenticate($request->token);
        //Si no hay usuario es que el token no es valido o que ha expirado
        if(!$user)
            return response()->json([
                'message' => 'Invalid token / token expired',
            ], 401);
        //Devolvemos los datos del usuario si todo va bien.
        return response()->json(['user' => $user]);

    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


}
