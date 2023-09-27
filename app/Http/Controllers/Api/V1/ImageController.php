<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ImageStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Image;


class ImageController extends Controller
{
    public function store(ImageStoreRequest $request) {
        $data = $request->validated();
        $user = User::where('api_token', $data['key'])->first();

        if($data['type'] == 'file') {
            try {
                $image = [];
                $image['path'] = $data['file']->store('images', 'public');
                $image['user_id'] = $user->id;

                Image::create($image);
                return response()->json(['message'=> 'success', 'url' => asset('storage') . '/' . $image['path']]);
            } catch(\Exception $e) {
                return response()->json(['message' => 'Unable to load image']);
            }
        }

        if($data['type'] == 'url') {
            try {
                $image = \Intervention\Image\Facades\Image::make($data['url']);
                $extension = pathinfo($data['url'], PATHINFO_EXTENSION);
                $fileName = time() . '.' . $extension;

                $image->save(storage_path('app/public/images/' . $fileName));
                $img = [];
                $img['path'] = 'images/' . $fileName;
                $img['user_id'] = $user->id;

                Image::create($img);
                return response()->json(['message'=> 'success', 'url' => asset('storage') . '/' . $img['path']]);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Unable to load image']);
            }
        }
    }
}
