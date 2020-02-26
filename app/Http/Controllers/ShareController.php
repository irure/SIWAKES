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
        
        $consumerKey = env('TWITTER_CONSUMER_KEY');
        $consumerSecret = env('TWITTER_CONSUMER_SECRET');
        $accessToken = $user->oauth_token;
        $accessTokenSecret = $user->oauth_token_secret;

        $twitter = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
        
        if($request->image && $request->image2){
            $picture1 = $twitter->upload("media/upload", ["media" => $request->image]);
            $picture2 = $twitter->upload("media/upload", ["media" => $request->image2]);
            
            $result = $twitter->post(
            "statuses/update",
                array(
                    "status" => $request->text,
                    "media_ids" => implode(",", [$picture1->media_id_string,$picture2->media_id_string])
                )
            );
        }else if($request->image){
            $picture1 = $twitter->upload("media/upload", ["media" => $request->image]);
            
            $result = $twitter->post(
            "statuses/update",
                array(
                    "status" => $request->text,
                    "media_ids" => implode(",", [$picture1->media_id_string])
                )
            );
        }else if($request->image2){
            $picture2 = $twitter->upload("media/upload", ["media" => $request->image2]);
            
            $result = $twitter->post(
            "statuses/update",
                array(
                    "status" => $request->text,
                    "media_ids" => implode(",", [$picture2->media_id_string])
                )
            );
        }else {
            $result = $twitter->post("statuses/update", array("status" => $request->text));
        }
        
        var_dump($result);
    }
}
