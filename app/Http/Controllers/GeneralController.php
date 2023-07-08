<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PetitionLog;
use App\Models\Resource;
Use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class GeneralController extends Controller
{
    public function home(){
        return view('welcome');
    }
    
    public function downloadResource($resourceId){
        $resource = Resource::find($resourceId);
        if(!empty($resource->filename) && Storage::disk('public')->exists($resource->filename)){
            return response()->download(public_path("/storage/".$resource->filename));
        }
        Alert::info('Not Available', 'Check back in coming days');
        return redirect()->back();
    }
}
