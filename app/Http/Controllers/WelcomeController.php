<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class WelcomeController extends Controller
{
    public function index()
    {
        // Fetch the logo from the first admin or use default
        $admin = Admin::first();
        $logo = $admin && $admin->logo ? asset('storage/' . $admin->logo) : asset('image/Gemini_Generated_Image_xxqbl3xxqbl3xxqb.png');

        return view('welcome', compact('logo'));
    }
}
