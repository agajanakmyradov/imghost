<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageStoreRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index() {
        $images = Image::where('user_id', Auth::user()->id)->paginate(30);
        //dd($images);
        return view('image.index', compact('images'));
    }

    public function create() {
        return view('image.create');
    }

    public function store(ImageStoreRequest $request) {
        $data = $request->validated();

       // dd(Auth::user()->id);
        $image = [];
        $image['path'] = $data['output']->store('images', 'public');
        $image['user_id'] = Auth::user()->id;

        Image::create($image);
        return back()->with('image_path', $image['path']);

    }

    public function destroy($id) {
        $image = Image::find($id);

        if($image->user_id != Auth::user()->id) {
            return back();
        }

        Storage::delete('/public/' . $image->path);
        $image->delete();

        return back()->with('deleted', 'The image was deleted');
    }


}
