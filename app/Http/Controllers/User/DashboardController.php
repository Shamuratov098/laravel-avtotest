<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use app\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard(){
        $user=Auth::user();
        return view('user.dashboard', compact('user'));
    }
}
