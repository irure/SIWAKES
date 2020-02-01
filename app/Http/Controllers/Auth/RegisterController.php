<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Socialite;
use App\SocialAccount;

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
    protected $redirectTo = '/home';

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    
    protected function registered(Request $request, $user)
    {
        return $user;
    }
    
    public function twlogin()
    {
        return Socialite::with('Twitter')->redirect();
    }

    public function twcallback()
    {
        $twitterUser = Socialite::driver('twitter')->user();
        
        $socialAccount = SocialAccount::firstOrNew([
            'provider'   => 'twitter',
            'account_id' => $twitterUser->getId(),
        ]);
        
        if ($socialAccount->exists) {
            $user = User::find($socialAccount->getAttribute('user_id'));
        } else {
            $user = User::create([
                'name'         => $twitterUser->getName(),
                'email'        => $twitterUser->getEmail(),
                'password'     => null,
                'twitter_id'   => $twitterUser->getNickName(),
                'account_id' => $twitterUser->getId(),
            ]);
        $socialAccount->setAttribute('user_id', $createdUser->id);
        $socialAccount->save();
        }
        
        return [
            'user'         => $user,
            'access_token' => $user->createToken(null, ['*'])->accessToken,
        ];
        
        
    }
}
