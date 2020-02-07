<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Charge;
use App\Task;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
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
        $searchavatar=new User;
        $searchavatar->avatar = $res;
       
       //メールアドレスで登録状況を調べる
       $user = User::where(['avatar' => $res])->first();
      
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
           $newuser->avatar = $searchavatar->avatar;
           
           //ユーザ作成     
           $newuser->save();
           //ログインしてトップページにリダイレクト
           Auth::login($newuser);
           
           $charge = new Charge;$charge->charge = '夫';$charge->user_id = $newuser->id;$charge->charge_id = 1;
           $charge2 = new Charge;$charge2->charge = '気づいた方';$charge2->user_id = $newuser->id;$charge2->charge_id = 2;
           $charge3 = new Charge;$charge3->charge = '妻';$charge3->user_id = $newuser->id;$charge3->charge_id = 3;
           
           $charge->save();$charge2->save();$charge3->save();
           $task = new Task;$task->howlong=640;$task->howtimes=5;$task->charge='夫';$task->task="仕事";$task->user_id=$newuser->id;
           $task1 = new Task;$task1->howlong=90;$task1->howtimes=7;$task1->charge='妻';$task1->task="掃除";$task1->user_id=$newuser->id;
           $task2 = new Task;$task2->howlong=90;$task2->howtimes=7;$task2->charge='妻';$task2->task="皿洗い";$task2->user_id=$newuser->id;
           $task3 = new Task;$task3->howlong=60;$task3->howtimes=7;$task3->charge='妻';$task3->task="朝ごはん";$task3->user_id=$newuser->id;
           $task4 = new Task;$task4->howlong=60;$task4->howtimes=7;$task4->charge='妻';$task4->task="昼ごはん";$task4->user_id=$newuser->id;
           $task5 = new Task;$task5->howlong=60;$task5->howtimes=7;$task5->charge='妻';$task5->task="夕ごはん";$task5->user_id=$newuser->id;
           $task6 = new Task;$task6->howlong=60;$task6->howtimes=5;$task6->charge='妻';$task6->task="洗濯";$task6->user_id=$newuser->id;
           $task7 = new Task;$task7->howlong=60;$task7->howtimes=4;$task7->charge='妻';$task7 ->task="買い出し";$task7->user_id=$newuser->id;
           $task8 = new Task;$task8->howlong=60;$task8->howtimes=3;$task8->charge='気づいた方';$task8->task="ゴミ出し";$task8->user_id=$newuser->id;
           $task9 = new Task;$task9->howlong=60;$task9->howtimes=2;$task9->charge='妻';$task9->task="布団干し";$task9->user_id=$newuser->id;
           
           $task->save();$task1->save();$task2->save();$task3->save();$task4->save();$task5->save();
           $task6->save();$task7->save();$task8->save();$task9->save();
           return redirect('/');
       }
       
   }
}
