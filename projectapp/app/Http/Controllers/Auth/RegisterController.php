<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Rules\PhoneNumber;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		Redirect::to('404')->send();
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
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'contactno' => ['nullable','string', new PhoneNumber],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
		//Create Candidate
		$user=   User::create([
            'name' => trim($data['firstname']." ".$data['lastname']),
            'firstname' => trim($data['firstname']),
            'lastname' => trim($data['lastname']),
            'gender' => $data['gender'],
            'contactno' => $data['contactno'],
            'whatsapp' => $data['whatsapp'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
		if($user){ 
		//Set Candidate Role
           \App\Models\RoleUser::create([
                'role_id' => 1,
                'user_id' => $user->id,
            ]);
			 event(new Registered($user));
			   return $user;
		}
    }
}
