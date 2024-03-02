<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Validator;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    public function registerS() {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',

        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = new User;
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = bcrypt(request()->password);
        $user->user_type = 'User';

        $user->save();
        Log::info('تم تسجيل الدخول بنجاح : ' . $user);
        return response()->json($user, 201);
    }




    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user=User::where('email','=',$request->email)->get();
        $user_type=User::where('email','=',$request->email)->value('user_type');
        //$user_group_name=User::where('email','=',$request->email)->value('group_name');
        return [
            'token'=>$token,
            'user_type'=>$user_type,
          //  'group_name'=>$user_group_name,
            'user'=>$user
            ];
    }




    public function profile()
    {
        return response()->json(auth()->user());
    }




    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }




    public function allUser()
{
    $users = User::all();
    return response()->json(['users' => $users]);
}

    // public function refresh()
    // {
    //     return $this->respondWithToken(auth()->refresh());
    // }




    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 60
    //     ]);
    // }

}
