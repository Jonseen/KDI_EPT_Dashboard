<?php
	namespace App\Http\Services;

	use Illuminate\Http\Request;
	use App\Http\Services\PetitionLogService;
	use Illuminate\Support\Facades\Log;

	class PetitionFilterService{

		private static function getFilters(Request $request){
			$fils = ['election_type', 'year', 'stage', 'state'];
			$filters = [];
			foreach($fils as $f){
				if($request->has($f)){
					$filters[$f] = $request->input($f);
				}
			}
			return $filters;
		}

		public function filterPetitionStats(Request $request){
			$filters = self::getFilters($request);
            return ['status'=>true, 'data'=> PetitionLogService::getPetitionStats($filters)];
	    }

	    public static function filterPetitionLogs(Request $request, int $page=1){
	    	$filters = self::getFilters($request);
	    	try{
	    		return [
	    			'status' => true, 
	    			'data' => PetitionLogService::getPetitionLogs($filters, $page)
	    		];
	    	}catch(\Exception $args){
	    		Log::error($args);
	    		return [
	    			'status' => false, 
	    			'error' => 'An error in the filteration service'
	    		];
	    	}
	    }

	    public static function filterStatePetitions(Request $request){
	    	$filters = self::getFilters($request);
	    	try{
	    		return [
	    			'status' => true,
	    			'data' => PetitionLogService::getPetitionsByStates($filters),
	    		];
	    	}catch(\Exception $args){
	    		Log::error($args);
	    		return [
	    			'status' => false,
	    			'error' => 'An error in the filteration service'
	    		];
	    	}
	    }

		public static function filterJudgementPetitions(Request $request, int $page=1){
			$filters = self::getFilters($request);
			// only give petitions in judgement stage
			$filters['stage'] = 'judgement';
	    	try{
	    		return [
	    			'status' => true, 
	    			'data' => PetitionLogService::getPetitionLogs($filters, $page)
	    		];
	    	}catch(\Exception $args){
	    		Log::error($args);
	    		return [
	    			'status' => false, 
	    			'error' => 'An error in the filteration service'
	    		];
	    	}
		}
	}
?>