<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTraits;


class UserController extends Controller
{
    use GeneralTraits;
    public function register(LoginRequest $request)
    {
        try{
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('TutsForWeb')->accessToken;

        //return response()->json(['token' => $token], 200);

        return response()->json([$user,'token' => $token], 200);
    }
    catch(\Exception $ex)
    {
        return $this->returnError($ex->getCode(), $ex->getMessage());
    }
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('TutsForWeb')->accessToken;
            $user = auth()->user();
            return response()->json(['user'=>auth()->user(),'token' => $token], 200);
          // return response()->json(['user' => auth()->user()], 200);
            //return $this->returnData('token', $token,$user);

        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }


    public function details()
    {
       // return response()->json(['user' => auth()->user()], 200);
        return $this->returnData('user', auth()->user());
    }
}
