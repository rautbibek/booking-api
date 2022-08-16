<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function medaiValidator(Request $request){
        return $this->validate($request,[
            'media'=>'required'
        ]);
        return response()->json([
            'message'=>'media uploaded succefully',
        ]);

    }
}
