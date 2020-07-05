<?php

namespace App\Http\Controllers;

use App\Sound;
use Storage;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class RecordController extends Controller
{

    public function index(Request $request, Response $response)
    {
        $sounds = Sound::orderBy('created_at', 'desc')->get();

        $data = $sounds->map(function ($item, $key) {
            $item['sound'] = Storage::disk('s3')->url($item['sound']);
            return $item;
        });
        //$sounds['sound'] = Storage::disk('s3')->url($sounds['sound']);

        return ['sounds' => $data];
    }

    public function store(Request $request, Response $response)
    {
        $post_sound = $request->file('sound');
        $path = Storage::disk('s3')->putFile('/', $post_sound, 'public');
        $sound = new Sound();

        $data = [
            'avatar' => $request->avatar,
            'sound' => $path
        ];

        $sound->fill($data)->save();
        $response_data = Sound::orderBy('created_at', 'desc')->first();
        $response_data['sound'] = Storage::disk('s3')->url($response_data['sound']);

        return ['sound' => $response_data];

    }
}
