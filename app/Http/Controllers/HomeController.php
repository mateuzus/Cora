<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Notifications\ListDaily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){



        return view('home');
    }
}
