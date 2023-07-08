<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PetitionLog extends Model
{
    use HasFactory;

    protected $table = "petition_log";
    protected $primaryKey = "sn";

    protected $fillable = [
        "petitioners_name",
        "petitioners_pol",
        "petition_number",
        "respondent_pol",
        "judgement",
        "stage",
        "grounds_of_petition",
        "ept_type",
        "election_type",
        "gpz",
        "state",
        "petition_filename",
    ];

    protected $hidden = [
        
    ];

    public static $states = [
        "Abia" => "ng-ab",
        "Adamawa" => "ng-ad",
        "Akwa Ibom" => "ng-ak", 
        "Anambra" => "ng-an", 
        "Bauchi" => "ng-ba",
        "Bayelsa" => "ng-by",
        "Benue" => "ng-be",
        "Borno" => "ng-bo",
        "Cross River" => "ng-cr",
        "Delta" => "ng-de",
        "Ebonyi" => "ng-eb",
        "Edo" => "ng-ed",
        "Ekiti" => "ng-ek",
        "Enugu" => "ng-en",
        "FCT" => "ng-fc",
        "Gombe" => "ng-go",
        "Imo" => "ng-im",
        "Jigawa" => "ng-ji",
        "Kaduna" => "ng-kd",
        "Kano" => "ng-kn",
        "Katsina" => "ng-kt",
        "Kebbi" => "ng-ke",
        "Kogi" => "ng-ko",
        "Kwara" => "ng-kw",
        "Lagos" => "ng-la",
        "Nasarawa" => "ng-na",
        "Niger" => "ng-ni",
        "Ogun" => "ng-og",
        "Ondo" => "ng-on",
        "Osun" => "ng-os",
        "Oyo" => "ng-oy",
        "Plateau" => "ng-pl",
        "Rivers" => "ng-ri",
        "Sokoto" => "ng-so",
        "Taraba" => "ng-ta",
        "Yobe" => "ng-yo",
        "Zamfara" => "ng-za",
    ];

    public static function getStates(){
        return array_keys(self::$states);
    }

    public static $petitionGrounds = [
        'NQC' => 'Not Qualify for Contest',
        'NCC' => 'Non-Compliance with Legal Framework/Corrupt Practices',
        'LMV' => 'Not Duly Elected by Majority of Lawful Votes Cast'
    ];

    public static $geoPoliticalZones = [
        "SE" => "South East",
        "SS" => "South South",
        "SW" => "South West",
        "NE" => "North East",
        "NW" => "North West",
        "NC" => "North Central",
    ];

    public static $electionTypes = [
        "Sen" => "Senatorial",
        "HoR" => "House of Reps",
        "Gov" => "Governorship",
        "S/HoA" => "State House of Assembly",
        "Pres" => "Presidential",
    ];

    public static $petitionStages = [
        "Pre-Hearing",
        "Hearing",
        "Ruling",
        "Judgement",
        "Withdrawn"
    ];

    public static $judgements = [
        "Hearing still ongoing",
        "Withdrawn",
        "Struck Out",
        "Dismissed",
        "Petition Upheld",
        "Petition Refused",
    ];

    public static $eptTypes = [
        "PEPC",
        "NASS EPT",
        "GOV/SHA EPT",
    ];

    public static function store(array $data){
        self::create($data);
        if(array_key_exists('file', $data)){
            $file = $data['file'];
            Storage::disk('public')->put($data['petition_filename'], file_get_contents($file->getRealPath()));
        }        
        return true;
    }

    public static function saveUpdate(array $data){
        $petition = PetitionLog::find($data['sn']);

        // replace the old file or rename the existing file
        if(array_key_exists('file', $data)){
            ($petition->petition_filename)? Storage::disk('public')->delete($petition->petition_filename) : null;
            Storage::disk('public')->put($data['petition_filename'], 
                                        file_get_contents($data['file']->getRealPath())
                                    );
        }else if($petition->petition_filename){
            $extension = pathinfo($petition->petition_filename, PATHINFO_EXTENSION);
            $data['petition_filename'] = $data['petition_filename'].'.'.$extension;
            Storage::disk('public')->move($petition->petition_filename, $data['petition_filename']);
        }
        unset($data['file']);
        DB::table('petition_log')
            ->where('sn', $data['sn'])
            ->update($data);
        return true;      
    }   
        
}
