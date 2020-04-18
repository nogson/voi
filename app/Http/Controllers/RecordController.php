<?php

namespace App\Http\Controllers;

use App\Sound;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class RecordController extends Controller
{

    public function index(Request $request, Response $response)
    {
        $sounds = Sound::orderBy('created_at', 'desc')->get();

        return ['sounds' => $sounds];
    }

    public function store(Request $request, Response $response)
    {
        $path = $request->file('sound')->store('public/sounds');

        $sound = new Sound();

        $data = [
            'avatar' => $request->avatar,
            'sound' => $replace = str_replace('public', 'storage', $path)
        ];

        $sound->fill($data)->save();

        $sounds = Sound::orderBy('created_at', 'desc')->get();

        return ['sounds' => $sounds];

//        $file = $request->file('sound');
//        // var_dump($file);
//        //$content = file_get_contents( $file->getRealPath() );
//       dd($request->all());
//
//        return ['request' =>  $request->files];
    }
}
