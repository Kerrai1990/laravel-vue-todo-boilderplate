<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $cred = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(Auth::attempt($cred)) {
            $success['id'] = Auth::user()->id;
            $success['name'] = Auth::user()->name;
            $success['token'] = Auth::user()->createToken("todo-app")->accessToken;
            return response()->json(['success' => $success]);
        }

        return response()->json(['error' => 'Unauthorised. Check details and try again'], 401);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
           'name' => 'required',
           'email' => 'required|email',
           'password' => 'required'
        ]);

        if($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        $success['token'] = $user->createToken('todo-app')->accessToken;
        $success['name'] = $user->name;

        return response()->json(['success' => $success]);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetails()
    {
        return response()->json(['success' => Auth::user()]);
    }
}
