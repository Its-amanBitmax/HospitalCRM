<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NurseController extends Controller
{
    public function get_users(){
        return view('admin.nurse.all-patients');
    }
}
