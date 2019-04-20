<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Models\Interfaces\UserRepositoryInterface;
use Bamilo\Marco\Models\Services\ResponseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation and create jwt token for user.
    |
    */
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var ResponseService
     */
    protected $responseService;

    /**
     * Create a new controller instance.
     * @param UserRepositoryInterface $userRepository
     * @param ResponseService $responseService
     */
    public function __construct()
    {

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
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required_without:cellphone', 'string', 'email', 'max:255', 'unique:users'],
            'cellphone' => ['required_without:email', 'string', 'unique:users'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return $this
     */
    protected function regularRegister(array $data)
    {

    }
}
