<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EPTStories extends Model
{
    use HasFactory;

    protected $table = "ept_stories";
    protected $keyType = "string";
    public $incrementing = false;

    protected $casts =[
        'paragraphs' => 'object',
    ];

    /**
     *  Adds a new story to the database
     */
    public static function add(string $title, string $reporter, $imageFile, array $pars, string $body=null){
        try{
            $story = new EPTStories();
            $story->id = "ST_".Str::random(10);
            $story->title = $title;
            $story->reporter = $reporter;
            $imageFilename = "/stories/{$story->id}.{$imageFile->extension()}";
            $story->image = $imageFilename;
            $story->body = $body;
            $story->paragraphs = $pars;
            $story->save();

            Storage::disk('public')->put($imageFilename, file_get_contents($imageFile->getRealPath()));
        }catch(\Exception $args){
            Log::error($args);
            throw new \Exception("An error occurred while attempting to add story");
        }
        return true;
    }
}
