<?php

namespace App\Http\Controllers;

use App\Sound;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    //
    public function store(Request $request, Response $response)
    {
        $sound = new Sound();

        $data = [
            'avatar' => $request->avatar,
        ];

        $sound->fill($data)->save();


        $path = $request->file('sound')->store('sounds');

        return $path;

//        $file = $request->file('sound');
//        // var_dump($file);
//        //$content = file_get_contents( $file->getRealPath() );
//       dd($request->all());
//
//        return ['request' =>  $request->files];
    }
}
