<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('admin.departments');
    }

    public function getDepartments()
    {
        $departments = Department::all();
        return response()->json($departments);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'department_id' => 'required|string|unique:departments,department_id',
            'department_name' => 'required|string|max:150',
            'department_code' => 'required|string|max:50|unique:departments,department_code',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $departmentId = $request->department_id;

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('departments', $imageName, 'public');
            $imageUrl = asset('storage/' . $path);
        }

        $department = Department::create([
            'department_id' => $departmentId,
            'department_name' => $request->department_name,
            'department_code' => $request->department_code,
            'image_url' => $imageUrl,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Department created successfully.', 'department' => $department]);
    }

    public function show($id)
    {
        $department = Department::findOrFail($id);
        return response()->json($department);
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'department_id' => 'required|string|unique:departments,department_id,' . $id,
            'department_name' => 'required|string|max:150',
            'department_code' => 'required|string|max:50|unique:departments,department_code,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $imageUrl = $department->image_url;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($imageUrl && Storage::disk('public')->exists($imageUrl)) {
                Storage::disk('public')->delete($imageUrl);
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('departments', $imageName, 'public');
            $imageUrl = asset('storage/' . $path);
        }

        $department->update([
            'department_id' => $request->department_id,
            'department_name' => $request->department_name,
            'department_code' => $request->department_code,
            'image_url' => $imageUrl,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Department updated successfully.']);
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return response()->json(['message' => 'Department deleted successfully.']);
    }
}
