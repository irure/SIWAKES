<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NotificationChannels\Twitter\TwitterChannel;
use App\Notifications\ShareResults;
use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Auth;
use App\User;

class ShareController extends Controller
{
    //
    public function create() {

        return view('product.create');

    }

    public function store(Request $request) {
        $user = Auth::user();
        
        $consumerKey = '5z1MzrqrP3gCDgoz6tM04GnSa';
        $consumerSecret = 'XUEDzMEHbvLTWxTWsfJ0EZRZNL96VGgRfWQXNJS1kADe4GnXv6';
        $accessToken = $user->oauth_token;
        $accessTokenSecret = $user->oauth_token_secret;

        $twitter = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
        
        if($request->image){
            $picture1 = $twitter->upload("media/upload", ["media" => $request->image]);
            
            $result = $twitter->post(
            "statuses/update",
                array(
                    "status" => "testtext",
                    "media_ids" => implode(",", [$picture1->media_id_string])
                )
            );
        }else{
            $result = $twitter->post("statuses/update", array("status" => $request->text));
        }
        
        var_dump($result);
    }
}
