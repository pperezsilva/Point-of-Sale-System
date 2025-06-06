<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class homeController extends Controller
{
    public function index(): View
    {
        if(!Auth::check()){
            return view('welcome');
        }
        return view('panel.index');
    }

}
