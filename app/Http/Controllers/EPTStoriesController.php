<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\EPTStories;

class EPTStoriesController extends Controller
{
    /**
    *   Add a new story
    */
    public static function addStory(Request $request){
        $data = null;
        try{
            $data = $request->validate([
                "title" => "required|string|min:5|max:300",
                "reporter" => "required|string",
                // 5mb max image size
                "image" => "required|max:5120",
                "body" => "nullable|string",
                "paragraph1" => "required|string",
                "paragraph2" => "nullable|string",
                "paragraph3" => "nullable|string"
            ]);
        }catch(\Exception $args){
            Alert::error("Validation Error", $args->getMessage());
            return redirect()->back();
        }
        
        try{
            $pars = [$data['paragraph1']];
            if($data['paragraph2']){
                $pars[] = $data['paragraph2'];
            }
            if($data['paragraph3']){
                $pars[] = $data['paragraph3'];
            }
            $result = EPTStories::add($data["title"], $data['reporter'], $request->file("image"), $pars);
            Alert::success("Success", "New Story saved");
        }catch(\Exception $args){
            Log::error($args);
            Alert::error("Error", "Something went wrong while adding a new story");
        }
        return redirect()->back();
    }

    /**
    *  Remove a story with all the comments
    */
    public static function deleteStory(Request $request){

    }

    /**
    *   Add comment to a particular story
    */
    public static function addComment(Request $request){

    }

    /**
    *   Remove a comment for a particular story
    */
    public static function removeComment(Request $request){
        
    }
}
