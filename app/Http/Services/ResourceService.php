<?php

namespace App\Http\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResourceService extends Controller
{
    public static function store(array $data, $file){
        $data['id'] = Str::random(10);
        $data['name'] = strtolower($data['name']);
        $filename = "/resources/{$data['name']}.{$file->extension()}";
        $data['filename'] = $filename;
        Resource::create($data);
        if(!$file){
            throw new \Exception('Invalid file argument, file cannot be null');
        }
        Storage::disk('public')->put($data['filename'], file_get_contents($file->getRealPath()));
    }

    public static function update(array $data, $file=null){
        $resource = Resource::find($data['id']);
        $data['name'] = strtolower($data['name']);
        if($file){
            $filename = "/resources/{$data['name']}.{$file->extension()}";
            Storage::disk('public')->delete($resource->filename);
            Storage::disk('public')->put($filename, file_get_contents($file->getRealPath()));
        }else{
            $oldFilename = $resource->filename;
            $extension = path_info($oldFilename, PATHINFO_EXTENSION);
            $filename = "/resources/{$data['name']}.{$extension}";
            Storage::disk('public')->move($oldFilename, $filename);
        }
        $resource->name = $data['name'];
        $resource->filename = $filename;
        return $resource->save();
    }

    public static function delete(string $id){
        $resource = Resource::find($id);
        if(!$resource){
            throw new \Exception('Attempting action on invalid petition');
        }
        Storage::disk('public')->delete($resource->filename);
        return Resource::destroy($id);
    }
}
