<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
        {
            $this->validate($request, [
                'email' => 'required|string',
                'password' => 'required|string',
            ]);

            $credentials = $request->only(['email', 'password']);

            if (! $token = Auth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid Email or Password'], 401);
            }

            return $this->respondWithToken($token);
        }

    public function register(Request $request){
        $this->validate($request, [
            'first_name'=>'required|string',
            'last_name'=>'required|string',
            'middle_name'=>'nullable|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'phone'=>'required|string|unique:users,phone',
            'adddress'=>'nullable|string'
        ]);

        $user=new User();
        $user->first_name=$request->first_name;
        $user->last_name=$request->last_name;
        $user->middle_name=$request->middle_name?$request->middle_name:null;
        $user->email=$request->email;
        $user->address=$request->address?$request->address:null;
        $user->password=app('hash')->make($request->password);
        $user->phone=$request->phone;
        $user->save();

        $token=JWTAuth::fromUser($user);

        return response(['user'=>$user,'token'=>$token],201);
    }
 }
