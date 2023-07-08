<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PetitionLog;
use Illuminate\Support\Str;
Use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class PetitionLogController extends Controller
{
    public function addPetition(Request $request){
        $data = $request->validate([
            'state' => 'required',
            'gpz' => 'required',
            'election_type' => 'required',
            'ept_type' => 'required',
            'grounds_of_petition' => 'required',
            'stage' => 'required',
            'petitioners_name' => 'required',
            'respondent_pol' => 'required',
            'petition_number' => 'required',
            'judgement' => 'required',
        ]);
        
        $data['petitioners_pol'] = null;
        $data['petition_number'] = strtoupper($data['petition_number']);
    
        $data['grounds_of_petition'] = json_encode($data['grounds_of_petition']);
        if($request->hasFile('petition_document')){
            $sn = Str::random(5);
            $file = $request->file('petition_document');
            $petNum = str_replace('/', '-', $data['petition_number']);
            $filename = "/petition-documents/$petNum-$sn.".$file->extension();
            $data['petition_filename'] = $filename;
            $data['file'] = $file;
        }
        try{
            PetitionLog::store($data);
            Alert::success('New Petition Added', 'Petition '.$data['petition_number'].' successully added');
        }catch(\Exception $args){
            Log::error($args);
            Alert::error('Request Failed', 'An error while processing your request');
        }
        return redirect()->back();
    }

    public function updatePetition(Request $request){
       $data = $request->validate([
            'sn' => 'required',
            'state' => 'required',
            'gpz' => 'required',
            'election_type' => 'required',
            'ept_type' => 'required',
            'grounds_of_petition' => 'required',
            'stage' => 'required',
            'petitioners_name' => 'required',
            'respondent_pol' => 'required',
            'petition_number' => 'required',
            'judgement' => 'required',
        ]);
        
        $data['grounds_of_petition'] = json_encode($data['grounds_of_petition']);
        $data['petition_number'] = strtoupper($data['petition_number']);
        $petNum = str_replace('/', '-', $data['petition_number']);
        $data['petition_filename'] = "/petition-documents/$petNum-".$data['sn'];

        if($request->hasFile('petition_document')){
            $file = $request->file('petition_document');            
            $data['petition_filename'] = $data['petition_filename'].".".$file->extension();
            $data['file'] = $file;
        }

        try{
            PetitionLog::saveUpdate($data);
            Alert::success('Update Successful', 'Petition update has been saved');
        }catch(\Exception $args){
            Log::error($args);
            Alert::error('Request Failed', 'An error while processing your request');
        }
        return redirect()->back();
    }

    /**
     * Remove a petition and the curresponding file
     * @param Request $request - contains the id of the petition to delete
     * @return RedirectResponse
     */
    public function deletePetition(Request $request){
        if($request->has('id')){
            $pet = PetitionLog::find($request->input('id'));
            if($pet->petition_filename){
                Storage::disk('public')->delete($pet->petition_filename);
            }            
            $pet->delete();
            Alert::success('Petition Deleted', 'Petition successully deleted');
        }else{
            Alert::error('Request Failed', 'Invalid Request');
        }
        return redirect()->back();
    }

    public function downloadPetition($petition){
        $petition = PetitionLog::find($petition);

        if(!empty($petition->petition_filename) && Storage::disk('public')->exists($petition->petition_filename)){
            return response()->download(public_path("/storage/".$petition->petition_filename));
        }
        Alert::info('Not Available', 'Check back in coming days');
        return redirect()->route('petitionLog');
    }

    public function petitionDetails($petition){
        try{
            $petitionLog = PetitionLog::find($petition);
            $grounds = [];
            $gPetitions = json_decode($petitionLog->grounds_of_petition);
            $petitionGrounds = ($gPetitions)? $gPetitions : explode(',', $petitionLog->grounds_of_petition);
            $petitionGrounds = array_map(function($data){
                return trim($data);
            }, $petitionGrounds);

            $petitionLog->grounds_of_petition = $petitionGrounds;
            return [
                'status' => true,
                'data' => $petitionLog,
            ];
        }catch(\Exception $args){
            Log::error($args);
            return ['status' => false, 'message' => 'Unable to load petition'];
        }
    }
}
