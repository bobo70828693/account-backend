<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        dd("login");
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $user = $this->userRepository->getOne(['email' => $request['email']]);

        if (empty($user)) {
            return response(['errors' => 'user not found'], 403);
        }

        if (Hash::check($request['password'], $user['password'])) {
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $response = [
                'token' => $token,
                'user'  => [
                    'name' => $user['name']
                ]
            ];
            return $this->responseMaker($response);
        } else {
            return $this->responseMaker(null, 403);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return $this->responseMaker(null, 200, 'Success logout');
    }

    public function self()
    {
        $user_id = Auth::user()->id;
        $user_data = $this->userRepository->getOne(['id' => $user_id]);

        $result = [
            'id'    => $user_id,
            'name'  => $user_data['name'],
            'email' => $user_data['email']
        ];

        return $this->responseMaker($result, 202);
    }
}
