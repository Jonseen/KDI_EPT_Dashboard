<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\PetitionLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EPTStoriesController;
use App\Models\PetitionLog;
use App\Http\Services\PetitionLogService;
use App\Http\Services\PetitionFilterService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/test', function(){
    return DB::table('petition_log')
                ->select(DB::raw("count(*) as count, state"))
                ->groupBy('state')
                ->get();
});


// simple api giving access to the petitions
Route::controller(PetitionFilterService::class)->name('filter.')->group(function(){
    Route::get('/petitions/stats/filter', 'filterPetitionStats')->name('stats');
    Route::get('/petitions/filter', 'filterPetitionLogs')->name('petitions');
    Route::get('/petitions/filter/{page?}', 'filterPetitionLogs')->name('petitions.page');
    Route::get('/petitions/map/filter', 'filterStatePetitions')->name('petitions.map');

    Route::get('/petitions/judgements/filter', 'filterJudgementPetitions')->name('petitions.judgements');
    Route::get('/petitions/judgements/filter/{page?}', 'filterJudgementPetitions')->name('petitions.judgements.page');
});

Route::get('/', [GeneralController::class, 'home'])->name('home');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login/auth', [AuthController::class, 'auth'])->name('auth');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function(){
    // user protected routes
    Route::get('/petitions/download/{petition}', [PetitionLogController::class, 'downloadPetition'])->name('petitions.download');
    Route::get('/resources/download/{resource}', [GeneralController::class, 'downloadResource'])->name('resources.download');
    // admin protected routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function(){
        Route::controller(AdminController::class)->group(function(){
            // resource managements
            Route::post('/resources/add', 'addResource')->name('resources.add');
            Route::post('/resources/update', 'updateResource')->name('resources.update');
            Route::post('/resources/delete', 'deleteResource')->name('resources.delete');
        });
        
        Route::controller(PetitionLogController::class)->group(function(){
            // petition management
            Route::post('/petitions/add', 'addPetition')->name('petitions.add');
            Route::post('/petitions/update', 'updatePetition')->name('petitions.update');
            Route::post('/petitions/delete', 'deletePetition')->name('petitions.delete');
            Route::get('/petition/details/{id}', 'petitionDetails')->name('petition.details');
        });

        // blog management
        Route::controller(EPTStoriesController::class)->group(function(){
            Route::post('/stories/add', 'addStory')->name('stories.add');
        });
    });

});


Route::controller(DashboardController::class)->group(function(){
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/petitions', 'petitions')->name('petitionLog');
    Route::get('/petitions/page/{page?}', 'petitions')->name('petitionLog');
    Route::get('/judgements', 'judgements')->name('judgementLog');
    Route::get('/judgements/page/{page?}', 'judgements')->name('judgementLog');
    Route::get('/analytics', 'analytics')->name('analytics');
    Route::get('/analytics/map', 'map')->name('map');
    Route::get('/community', 'community')->name('community');
    Route::get('/resources', 'resources')->name('resources');
    Route::get('/about', 'about')->name('about');
    Route::get('/user/profile', 'userProfile')->name('user.profile');
    Route::get('/story/{id}', 'story')->name('story');
    Route::get('/blog', 'blog')->name('blog');
    Route::get('/story_1', 'story_1')->name('story_1');
    Route::get('/story_2', 'story_2')->name('story_2');
    
});