<?php

namespace App\Http\Controllers\UserMasterAuth;

use App\Mail\RegisteredMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use KW\Infrastructure\Eloquents\UserMaster;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user_masters'],
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ]);
    }

    /**
     * @param array $data
     * @return \KW\Infrastructure\Eloquents\UserMaster
     */
    protected function create(array $data)
    {
        return UserMaster::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validate = $this->validator($request->all());

        if ($validate->fails()) {
            return new JsonResponse($validate->errors());
        }

        event(new Registered($userMaster = $this->create($request->all())));

        return new JsonResponse($userMaster);
    }
}
