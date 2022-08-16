<?php

namespace App\Http\Controllers;

use App\Models\BookingType;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(){
        $booking_type = BookingType::orderBy('id','desc')->get();
        return response()->json($booking_type);
    }
}
