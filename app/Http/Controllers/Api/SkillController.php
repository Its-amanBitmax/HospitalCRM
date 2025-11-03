<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Speciality;

class SkillController extends Controller
{
    // Fetch all records
 public function index(Request $request)
{
    
    $skills = \App\Models\Speciality::all();

    return response()->json([
        'status' => true,
        'message' => 'All skills fetched successfully',
        'data' => $skills
    ]);
}

}
