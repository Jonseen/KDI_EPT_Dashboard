<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Services\PetitionLogService;
use App\Models\PetitionLog;
use App\Models\Resource;
use App\Models\EPTStories;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function dashboard(){
        $totalPetitions = PetitionLog::all()->count();
        $dispensedPetitions = PetitionLogService::getJudgmentLogs()['totalJudgements'];
        
        $percentDispensed = ($totalPetitions == 0)? 0 : $dispensedPetitions/$totalPetitions * 100;
        $percentDispensed = round($percentDispensed, 1);
        $catStats = PetitionLogService::getCategoryStats();
        $geozonesStats = PetitionLogService::getGeozonesStats();
        $groundsOfPetitionStats = PetitionLogService::getGroundsOfPetitionStat();

        return view('dashboard', [
            'title' => 'dashboard',
            'totalPetitions' => $totalPetitions,
            'dispensedPetitions' => $dispensedPetitions,
            'percentDispensed' => $percentDispensed,
            'catStats' => json_encode($catStats),
            'geozonesStats' => json_encode($geozonesStats),
            'groundsOfPetitionStats' => json_encode($groundsOfPetitionStats),
            'states' => PetitionLogService::getStates(),
        ]);
    }

    public function petitions(int $page=1){
        $data = PetitionLogService::getPetitionLogs(page: $page);
        $data['title'] = 'petitions';
        return view('petition-log', $data);
    }

    public function judgements(int $page=1){
        $data = PetitionLogService::getJudgmentLogs(page: $page);
        $data['title'] = "judgements";
        return view('judgement-log', $data);
    }

    public function analytics(){
        $yearlyScores = PetitionLogService::getPetitionDataByYear();
        $totalPetitions = PetitionLog::all()->count();
        
        return view('analytics', [
            'title' => 'analytics',
            'totalPetitions' => $totalPetitions,
            'yearlyTrends' => json_encode($yearlyScores),
            'states' => PetitionLogService::getStates(),
        ]);
    }

    public function community(){
        return view('community', ['title'=>'community']);
    }

    public function resources(){
        $resources = Resource::all();
        return view('resources', [
            'title' => 'resources',
            'resources' => $resources,
        ]);
    }

    public function blog(){
        return view('blog', ['title'=>'blog']);
    }

    public function story(string $id){
        $story = EPTStories::find($id);
        if(!$story){
            Alert::error('Invalid Request');
            return redirect()->back();
        }
        return view('story', [
            'title' => 'blog',
            'story' => $story,
        ]);
    }

    public function story_1(){
        return view('story_1', ['title'=>'blog']);
    }
    public function story_2(){
        return view('story_2', ['title'=>'blog']);
    }

    public function map(){
        return view('map', [
            'title' =>'petitions-map',
            'stats' => json_encode(PetitionLogService::getPetitionsByStates()),
            ]);
    }

    public function userProfile(){
        return view('my-profile', [
            'title' => 'user-profile',
        ]);
    }

    public function about(){
        return view('about-page',[
            'title' => 'about',
        ]);
    }
}
