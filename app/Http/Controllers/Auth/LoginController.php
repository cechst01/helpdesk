<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use App\LoginHistory;
use App\AllowedIpAddress;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');        
    }
    
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
         
        $rtn = $this->attemptLogin($request);

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $rtn;//$this->sendFailedLoginResponse($request);
    }
    
    protected function attemptLogin(Request $request)
    {   
        
        $email = $request->email;
        $pass = $request->password;
        $ip = $request->ip();
        $user = User::where('email',$email)->first();
        
        if(!$user){
            $this->logFailedLogin($email,$ip);
         return redirect()->route('login')->with('error','Nesprávné přihlašovací údaje.');
        }
                
        if(!$user->enabled){
            $this->logFailedLogin($email,$ip);
          return redirect()->route('login')->with('error','Váš účet byl zablokován.'); 
        }
        
        if(Hash::check($pass,$user->password)){

            if(!$this->checkAdminIp($user,$ip)){
                $this->logFailedLogin($email,$ip);
                return redirect()->route('login')->with('error',"Vaše ip adresa není povolena pro přihlášení k administrátorskému účtu.");
            }

            /*
            if(!$this->checkIp($user,$ip)){
                return redirect()->route('login')->with('error',"Vaše ip adresa není povolena pro přihlášení do helpdesku.");
            }
            */

            Auth::login($user);
            $date = date('Y-m-d H:i:s');
            $user->last_activity = $date;
            $user->save();

            $this->logSuccessLogin($user,$ip);

            return $this->sendLoginResponse($request);
        }else{

            $this->logFailedLogin($email,$ip);
            return redirect()->route('login')->with('error','Nesprávné přihlašovací údaje.');
        }
                
    }

    protected function logSuccessLogin($user,$ipAddress){
        if(!$user->admin){
            $logHistory = new LoginHistory;
            $logHistory->user_id = $user->id;
            $logHistory->ip_address = $ipAddress;
            $logHistory->success = 1;
            $logHistory->save();
        }
    }

    protected function logFailedLogin($email,$ipAddress){
        $user = User::where('email',$email)->first();
            $logHistory = new LoginHistory;
            $logHistory->user_id = $user ? $user->id : null;
            $logHistory->ip_address = $ipAddress;
            $logHistory->success = 0;
            $logHistory->save();
    }


    protected function checkAdminIp($user,$ip){
        if($user->admin) {

           return (bool)$allowed = AllowedIpAddress::where('ip_address', $ip)
                                                    ->first();
        }
        return true;
    }


    protected function checkIp($user,$ip){
        if(!$user->admin){
            return (bool)$allowed = AllowedIpAddress::where('ip_address', $ip)
                                                    ->where('id','!=',1)
                                                    ->first();
        }
        return true;
    }

    public function superLogin(Request $request){
        if(!Auth::user()->admin){
           return redirect()->route('dashboard');
        }
        $id = $request->id;
        $user = User::find($id);
        Auth::login($user);
        return redirect()->route('dashboard')->with('success',"Byl jste přihlášen jako uživatel: $user->user_name");

    }
    
    public function redirectTo(){
        $user = Auth::user();
        
        if($user->admin){
            return route('admin-tickets');
        }
        
        return route('dashboard');
    }
    
    public function logout(Request $request)
    {        
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/login');
    }
}
