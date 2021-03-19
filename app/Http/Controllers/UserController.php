<?php

namespace App\Http\Controllers;

use App\User;
use Session;
use DB;
use Auth;
class UserController extends Controller
{

    public function getPendingUsers()
    {
        $data['users'] = User::whereNull('approved_at')->get();
        $data['pending_registration_requests_count'] = $data['users']->count();      
        return view('auth.pendingUsers', $data);
    }

    public function approve($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->update(['approved_at' => now()]);
        Session::flash('status', 'Successfully approved ' . $user['name']);
        return redirect()->route('getPendingUsers')->withMessage('User approved successfully');
    }
}
