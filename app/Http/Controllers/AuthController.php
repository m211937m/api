<?php

namespace App\Http\Controllers;

use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
class AuthController extends Controller
{
    use GeneralTrait;
    public function login(Request $request){
        try{
            $rulse =[
                'email' => ['required','email','exists:admins,email'],
                'password' =>['required','min:8'],
            ];
            $validator = validator::make($request->all(), $rulse);
            if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $credentials = $request->only(['email','password']);
            $token = Auth::guard('admin-api')->attempt($credentials);
            if(!$token){
                return $this->returnError('E001','بيانات الدخول غير صحيحة ');
            }
            $admin = Auth::guard('admin-api')->user();
            $admin->api_token = $token;
            return $this->returnDate('admin', $admin);
        }
        catch(\Exception $e){
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }
    public function logout(Request $request){
        try{
           $token = $request->header('auth-token');
           if($token){
               JWTAuth::setToken($token)->invalidate();
               return $this->returnSuccess('logged out Successfully');
           }
           else{
               return $this->returnError('','some thing went wrone');
           }
        }
        catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
            return $this->returnError('', $e->getMessage());
        }
    }
}
