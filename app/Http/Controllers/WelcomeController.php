<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class WelcomeController extends Controller
{
    public function index()
    {
        // Fetch organization info from the first admin or use defaults
        $admin = Admin::first();
        $logo = $admin && $admin->logo ? asset('storage/' . $admin->logo) : asset('image/Gemini_Generated_Image_xxqbl3xxqbl3xxqb.png');
        $hospital_name = $admin ? $admin->hospital_name : 'MediCare Hospital';
        $company_address = $admin ? $admin->company_address : 'Default Address';
        $company_contact = $admin ? $admin->company_contact : '9876543210';
        $company_email = $admin ? $admin->company_email : 'care@medicarehospital.com';
        $company_website = $admin ? $admin->company_website : 'https://medicarehospital.com';
        $favicon = $admin && $admin->favicon ? asset('storage/' . $admin->favicon) : asset('favicon.ico');

        return view('website.welcome', compact('logo', 'hospital_name', 'company_address', 'company_contact', 'company_email', 'company_website', 'favicon'));
    }
}
