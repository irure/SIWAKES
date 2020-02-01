<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use Storage;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)
    {
        return $user;
    }
    
    protected function loggedOut(Request $request)
    {
    // セッションを再生成する
    $request->session()->regenerate();

    return response()->json();
    }
    
    //Callback処理
   public function handleProviderCallback()
   {
       // ユーザ属性を取得
       try {
           $userSocial = Socialite::driver('twitter')->user();
       } catch (Exception $e) {
           // OAuthによるユーザー情報取得失敗
           return redirect()->route('/')->withErrors('ユーザー情報の取得に失敗しました。');
       }
       //メールアドレスで登録状況を調べる
       $user = User::where(['twitter_id' => $userSocial->getNickname()])->first();
      
       //メールアドレス登録の有無で条件分岐
       if($user){
           //email登録がある場合の処理
           //twitter id　が変更されている場合、DBアップデード
           if($user->twitter_id  !== $userSocial->getNickname()){
               $user->twitter_id = $userSocial->getNickname();
               $user->save();
           }
           
           //ログインしてトップページにリダイレクト
           Auth::login($user);
           return redirect('/');
       }else{
           //メールアドレスがなければユーザ登録
           $newuser = new User;
           $newuser->name = $userSocial->getName();
           $newuser->email = $userSocial->getEmail();
           $newuser->twitter_id = $userSocial->getNickname();
           
           
           
           
           //ユーザーホームのURL
            $screen_name = $userSocial->getNickname();     //ユーザー名
            $url = "https://twitter.com/".$screen_name;
 
            $html = file_get_contents($url);
            if(!empty($html)){
                //data-resolved-url-large要素にオリジナルアイコンのURLがある
                $pattern = '/data\-resolved\-url\-large=".*?"/';
                $searched = preg_match($pattern, $html, $match, PREG_OFFSET_CAPTURE, 0);
                //マッチした文字列から不要部分（要素名、ダブルクォーテーション）を除く
                $res = preg_replace("/(data\-resolved\-url\-large=)|\"/","",$match[0][0]);
            }else{
                $res = false;
            }
            $newuser->avatar = $res;
           
           // 画像の取得
           /*$img = file_get_contents($userSocial->avatar_original);
           if ($img !== false) {
               $file_name = $userSocial->id . '_' . uniqid() . '.jpg';
               Storage::put('public/profile_images/' . $file_name, $img);
               $newuser->avatar = $file_name;
           }*/
           //ユーザ作成     
           $newuser->save();
           //ログインしてトップページにリダイレクト
           Auth::login($newuser);
           return redirect('/');
       }
       
   }
}
