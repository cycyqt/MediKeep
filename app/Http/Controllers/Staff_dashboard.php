<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Staff_dashboard extends Controller
{
    public function home ()
    {
        return view('staff.home');
    }
    public function add ()
    {
        return view('staff.add');
    }
    public function list ()
    {
        return view('staff.list');
    }

}
