<?php

namespace App\Http\Controllers;

use App\Models\BookingType;
use Illuminate\Http\Request;

class BookingTypeController extends Controller
{
    public function index(){
        $booking_type = BookingType::orderBy('booking_type','asc')->get();
        return response()->json($booking_type);
    }
}
