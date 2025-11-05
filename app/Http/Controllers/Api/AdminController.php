<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function getOrganizationDetails()
    {
        // Fetch the first admin record (assuming single organization)
        $admin = Admin::first();

        if (!$admin) {
            return response()->json([
                'status' => false,
                'message' => 'Organization details not found.',
            ], 404);
        }

        // Return only organization-related fields
        return response()->json([
            'status' => true,
            'message' => 'Organization details retrieved successfully.',
            'data' => [
                'hospital_name' => $admin->hospital_name,
                'logo' => $admin->logo,
                'favicon' => $admin->favicon,
                'company_address' => $admin->company_address,
                'company_contact' => $admin->company_contact,
                'company_email' => $admin->company_email,
                'company_website' => $admin->company_website,
            ],
        ], 200);
    }
}
