<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpecialityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specialities = Speciality::select('id', 'skill', 'image', 'created_at')
            ->orderBy('skill')
            ->get()
            ->map(function ($speciality) {
                $speciality->image_url = $speciality->image ? Storage::url($speciality->image) : null;
                return $speciality;
            });

        return view('admin.specialities.index', compact('specialities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.specialities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'skill' => 'required|string|max:255|unique:specialities,skill',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['skill']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('specialities', 'public');
        }

        Speciality::create($data);

        return redirect()->route('admin.specialities.index')
                         ->with('success', 'Speciality created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $speciality = Speciality::findOrFail($id);
        $speciality->image_url = $speciality->image ? Storage::url($speciality->image) : null;

        return view('admin.specialities.show', compact('speciality'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $speciality = Speciality::findOrFail($id);
        $speciality->image_url = $speciality->image ? Storage::url($speciality->image) : null;

        return view('admin.specialities.edit', compact('speciality'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $speciality = Speciality::findOrFail($id);

        $request->validate([
            'skill' => 'required|string|max:255|unique:specialities,skill,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['skill']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($speciality->image) {
                Storage::disk('public')->delete($speciality->image);
            }
            $data['image'] = $request->file('image')->store('specialities', 'public');
        }

        $speciality->update($data);

        return redirect()->route('admin.specialities.index')
                         ->with('success', 'Speciality updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $speciality = Speciality::findOrFail($id);

        // Delete image
        if ($speciality->image) {
            Storage::disk('public')->delete($speciality->image);
        }

        $speciality->delete();

        return redirect()->route('admin.specialities.index')
                         ->with('success', 'Speciality deleted successfully.');
    }
}