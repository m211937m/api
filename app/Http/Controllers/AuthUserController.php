<?php

namespace App\Http\Controllers;

use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthUserController extends Controller
{
    use GeneralTrait;
    public function login(Request $request){
        try{
            $rules = [
                "email" => ["required","email"],
                "password" => ['required','min:8']
            ];
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code , $validator);
            }
            $cretetials = $request->only(['email','password']);
            $token = Auth::guard('user-api')->attempt($cretetials);
            if(!$token){
                return $this->returnError('E001','بيانات الدخول غير صحيحة ');
            }
            $user = Auth::guard('user-api')->user();
            $user->api_token = $token;
            return $this->returnDate('admin', $user);


        }catch(\Exception $e){

        }
    }
}
