<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WebController extends Controller
{
    public function show() 
    {
        return view('web');
    }

    public function store()
    {

    }
}
