<?php
namespace App\Classes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Feed_back;

class HandleFeedBack{

    public static function addToDatabase( $request  ){

        $feddBack               = new Feed_back();
        $feddBack->name         = $request->input('name');
        $feddBack->phone_number = $request->input('phone_number');
        $feddBack->text         = $request->input('text');

        $feddBack->save();

        return 'Your message has been accepted!';

    }

    public static function addToFile( $request, $file ){


        $data = [
            'name'         => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'text'         => $request->input('text'),
            'date'         => date("Y-m-d", time() )
        ];


        $json = json_decode(Storage::get( $file ), true);

        $json[] = $data;

        Storage::put($file, json_encode($json, JSON_PRETTY_PRINT));

    }

}