<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Storage;
use App\Models\Feed_back;

use App\Classes\HandleFeedBack;

class FormController extends Controller
{
    use  ValidatesRequests;


    public function submit(Request $request){


        $validated = $this::validate($request, [
            'name'         => 'required|max:70',
            'phone_number' => 'required|numeric|digits:11',
            'text'         => 'required|max:1000',
        ]);


        $responseDb = HandleFeedBack::addToDatabase($request);
        $statusFs   = HandleFeedBack::addToFile($request, 'feedBackData.txt');

        return response()->json(['code' => '0', 'msg'=> $responseDb ]);
    }

}
