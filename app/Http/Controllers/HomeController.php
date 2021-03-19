<?php

namespace App\Http\Controllers;

use App\User;
use App\Booking;
use Illuminate\Http\Request;
use Auth;
use DB;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home()
    {
        $data = [];
        $data['pending_registration_requests_count'] = (User::whereNull('approved_at')->get())->count();
        $data ['booking_requests_count'] = Booking::where('owner_id', '=', Auth::user()->id)->get()->count();
        return view('home', $data);
    }

    public function approve()
    {
        return view('auth.approval');
    }
}
