<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Services\ResourceService;

class AdminController extends Controller
{   
    public function addResource(Request $request){
        if(!$request->has(["name","resource_doc"])){
            Alert::error("Missing Data", "Some required fields are missing");
            return redirect()->back(); 
        }

        $data = $request->validate([
            "name" => "required",
            "resource_doc" => "required"
        ]);

        ResourceService::store([
            "name" => $data['name'],
        ], $request->file('resource_doc'));
        Alert::success("New Resource Added", "Your request completed successfully");
        return redirect()->back();
    }

    public function updateResource(Request $request){
        if($request->has('id')){
            $data = $request->validate([
                "name" => "required",
            ]);
            $data = $request->only(['data']);
            ResourceService::update($data, $request->file('resource_doc'));
            Alert::success("Update Complete", "Resource Update Completed Successfully");
        }else{
            Alert::error('Error', 'Invalid Request');
        }        
        return redirect()->back();
    }

    public function deleteResource(Request $request){
        if($request->has('id')){
            ResourceService::delete($request->input('id'));
            Alert::success("Item Deleted", "Item has been successfully removed");
        }else{
            Alert::error('Error', 'Invalid Request');
        }        
        return redirect()->back();
    }
}
