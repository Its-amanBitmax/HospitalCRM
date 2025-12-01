<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Relative;

class RelativeController extends Controller
{
    /**
     * 🧾 Get all relatives of logged-in user
     */
   public function index(Request $request)
{
    $user = $request->user();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized',
        ], 401);
    }

    $relatives = Relative::where('user_id', $user->id)->get();

    // Convert image to full URL
    $relatives->each(function ($relative) {
        if (!empty($relative->image)) {
            // Avoid double path if already full URL
            if (!str_starts_with($relative->image, 'http')) {
                $relative->image = asset(
                    'storage/' . ltrim($relative->image, '/')
                );
            }
        } else {
            $relative->image = null;
        }
    });

    return response()->json([
        'status' => true,
        'relatives' => $relatives,
    ], 200);
}

    /**
     * ➕ Add a new relative
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:Male,Female,Other',
            'relation' => 'nullable|string|max:50',
            'blood_group' => 'nullable|string|max:5',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('relatives', 'public');
        }

        $relative = Relative::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender,
            'relation' => $request->relation,
            'blood_group' => $request->blood_group,
            'image' => $imagePath,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Relative added successfully.',
            'relative' => $relative
        ]);
    }

    /**
     * 🔍 View one relative
     */
    public function show(Request $request, $relative_id)
    {
        $user = $request->user();

        $relative = Relative::where('relative_id', $relative_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$relative) {
            return response()->json([
                'status' => false,
                'message' => 'Relative not found.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'relative' => $relative
        ]);
    }

    /**
     * ✏️ Update relative
     */
    public function update(Request $request, $relative_id)
    {
        $user = $request->user();

        $relative = Relative::where('relative_id', $relative_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$relative) {
            return response()->json([
                'status' => false,
                'message' => 'Relative not found.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:Male,Female,Other',
            'relation' => 'nullable|string|max:50',
            'blood_group' => 'nullable|string|max:5',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('relatives', 'public');
            $relative->image = $imagePath;
        }

        $relative->update($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Relative updated successfully.',
            'relative' => $relative
        ]);
    }

    /**
     * 🗑️ Delete relative
     */
    public function destroy(Request $request, $relative_id)
    {
        $user = $request->user();

        $relative = Relative::where('relative_id', $relative_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$relative) {
            return response()->json([
                'status' => false,
                'message' => 'Relative not found.'
            ], 404);
        }

        $relative->delete();

        return response()->json([
            'status' => true,
            'message' => 'Relative deleted successfully.'
        ]);
    }
}
