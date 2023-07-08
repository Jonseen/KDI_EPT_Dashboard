<?php
    namespace App\Http\Services;

    use App\Models\PetitionLog;
    use Illuminate\Support\Facades\DB;
    
    class PetitionLogService{

        public static function getPetitionStats(array $filters){
            $totalPetitions = PetitionLog::where($filters)->count();
            $dispensedPetitions = count(PetitionLogService::getJudgmentLogs($filters)['judgements']);
            
            $percentDispensed = ($totalPetitions == 0)? 0 : $dispensedPetitions/$totalPetitions * 100;
            $percentDispensed = round($percentDispensed, 1);
            $catStats = PetitionLogService::getCategoryStats($filters);
            $geozonesStats = PetitionLogService::getGeozonesStats($filters);
            $groundsOfPetitionStats = PetitionLogService::getGroundsOfPetitionStat($filters);

            $data = [
                'totalPetitions' => $totalPetitions,
                'dispensedPetitions' => $dispensedPetitions,
                'percentDispensed' => $percentDispensed,
                'catStats' => json_encode($catStats),
                'geozonesStats' => json_encode($geozonesStats),
                'groundsOfPetitionStats' => json_encode($groundsOfPetitionStats),
            ];

            return $data;
        }

        public static function getStates(){
            return DB::table('petition_log')
                    ->select('state')
                    ->distinct()
                    ->get();
        }

        public static function getPetitionsByStates($filters=[]){
            $states = array_keys(PetitionLog::$states);
            $petitionCounts = array_fill_keys($states, 0);
            $stats = [];
            $pCounts = DB::table('petition_log')
                                ->select(DB::raw("count(*) as count, state"))
                                ->groupBy('state')
                                ->where($filters)
                                ->get();
            foreach($pCounts as $data){
                $petitionCounts[$data->state] = $data->count;
            }
            foreach($petitionCounts as $state => $count){
                $stats[] = [PetitionLog::$states[$state], $count];
            }
            return $stats;
        }

        public static function getPetitionLogs(array $filters=[], int $page=1){
            $petCount = PetitionLog::where($filters)->count();
            $totalPages = intdiv($petCount, 10) + (($petCount % 10 > 0)? 1 : 0);
            $newPage = ($page > $totalPages)? $totalPages : $page;
            $newPage = ($newPage > 0)? $newPage : 1;

            $page = $newPage;

            $petitions = DB::table('petition_log')
                            ->skip(($page - 1)*10)
                            ->limit(10)
                            ->orderByDesc('sn')
                            ->where($filters)
                            ->get()->map(function($pet){
                                $dLink = route('petitions.download', $pet->sn);
                                $pet->download_link = $dLink;
                                return $pet;
                            });
        
            $pageLinks = [];
            $pageLinks['prev'] = ($page > 1)? route('petitionLog', $page - 1) : null;
            $pageLinks['next'] = ($page < $totalPages)? route('petitionLog', $page + 1) : null;
            $pageLinks['otherLinks'] = [];

            for($i = 1; $i <= $totalPages; $i++){
                $pageLinks['otherLinks'][] = route('petitionLog', $i);
            }
            $sn = range(($page - 1) * 10 + 1, $page * 10);

            return [
                'petitions' => $petitions,
                'totalPages' => $totalPages,
                'pageLinks' => $pageLinks,
                'sn' => $sn,
                'page' => $page,
            ];
        }

        public static function getJudgmentLogs(array $filters=[], int $page=1){
            $petCount = PetitionLog::where($filters)->orWhere('stage', 'judgement')->orWhere('stage', 'withdrawn')->count();
            $totalPages = intdiv($petCount, 10) + (($petCount % 10 > 0)? 1 : 0);
            $newPage = ($page > $totalPages)? $totalPages : $page;
            $newPage = ($newPage > 0)? $newPage : 1;

            $page = $newPage;

            $petitions = DB::table('petition_log')
                            ->skip(($page - 1)*10)
                            ->limit(10)
                            ->orderByDesc('sn')
                            ->where($filters)
                            ->orWhere('stage', 'judgement')
                            ->orWhere('stage', 'withdrawn')
                            ->get()->map(function($pet){
                                $dLink = route('petitions.download', $pet->sn);
                                $pet->download_link = $dLink;
                                return $pet;
                            });
        
            $pageLinks = [];
            $pageLinks['prev'] = ($page > 1)? route('judgementLog', $page - 1) : null;
            $pageLinks['next'] = ($page < $totalPages)? route('judgementLog', $page + 1) : null;
            $pageLinks['otherLinks'] = [];

            for($i = 1; $i <= $totalPages; $i++){
                $pageLinks['otherLinks'][] = route('judgementLog', $i);
            }
            $sn = range(($page - 1) * 10 + 1, $page * 10);

            return [
                'judgements' => $petitions,
                'totalJudgements' => PetitionLog::where('stage', 'judgement')
                                                ->orWhere('stage', 'withdrawn')
                                                ->count(),
                'totalPages' => $totalPages,
                'pageLinks' => $pageLinks,
                'sn' => $sn,
                'page' => $page,
            ];
        }
        
        public static function getCategoryStats(array $filters=[]){
            $categories = array_keys(PetitionLog::$electionTypes);
            $categoriesCount = [];
            foreach(PetitionLog::$electionTypes as $code => $cat){
                $categoriesCount[] = PetitionLog::where('election_type', $cat)
                                                    ->where($filters)->count();
            }
            return [$categories, $categoriesCount];
        }
        
        public static function getGeozonesStats(array $filters=[]){
            $zones = array_keys(PetitionLog::$geoPoliticalZones);
            $zonesCount = [];
            foreach(PetitionLog::$geoPoliticalZones as $code => $gpz){
                $zonesCount[] = PetitionLog::where('gpz', $gpz)
                                            ->where($filters)->count();
            }            
            return [$zones, $zonesCount];
        }
        
        public static function getPetitionDataByYear(){
            $years = [];
            $data = [];
            $result = DB::table('petition_yearly_scores')->select()->orderBy('year')->get();
            
            foreach($result as $d){
                $years[] = $d->year;
                $data[] = $d->total;
            }
            return [$years, $data];
        }

        public static function getGroundsOfPetitionStat(array $filters=[]){
            $allGrounds = DB::table('petition_log')
                            ->select('grounds_of_petition')
                            ->where($filters)
                            ->get();
            $stats = ['NQC' => 0, 'NCC' => 0, 'LMV' => 0];
            $grounds = [];
            foreach($allGrounds as $ground){
                $gPetitions = json_decode($ground->grounds_of_petition);
                $newGrounds = ($gPetitions)? $gPetitions: explode(',', $ground->grounds_of_petition);
                $grounds = array_merge($grounds, $newGrounds);
            }
            foreach($grounds as $gnd){
                $stats[strtoupper(trim($gnd))] += 1;
            }
            return [array_keys($stats), array_values($stats)];
        }
    }
?>