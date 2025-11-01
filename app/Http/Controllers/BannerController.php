<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        return view('admin.banner');
    }

    // ✅ Store new banner
    public function store(Request $request)
    {
        $request->validate([
            'banner_id' => 'required|string|unique:banners,banner_id',
            'title' => 'required|string|max:150',
            'redirect_url' => 'required|string|max:255',
            'position' => 'required|in:Top,Sidebar,Bottom,HomePage',
            'status' => 'required|in:Active,Inactive',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // ✅ Save image file
        $imagePath = $request->file('image')->store('uploads/banners', 'public');

        Banner::create([
            'banner_id' => $request->banner_id,
            'title' => $request->title,
            'image_url' => '/storage/' . $imagePath,
            'redirect_url' => $request->redirect_url,
            'position' => $request->position,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Banner added successfully']);
    }

    // ✅ Fetch all banners
    public function getBanners()
    {
        $banners = Banner::all();
        return response()->json($banners);
    }

    // ✅ Update banner
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'banner_id' => 'required|string|unique:banners,banner_id,' . $id,
            'title' => 'required|string|max:150',
            'redirect_url' => 'required|string|max:255',
            'position' => 'required|in:Top,Sidebar,Bottom,HomePage',
            'status' => 'required|in:Active,Inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagePath = $banner->image_url;

        // ✅ If new image uploaded
        if ($request->hasFile('image')) {
            if ($banner->image_url && file_exists(public_path($banner->image_url))) {
                unlink(public_path($banner->image_url));
            }
            $imagePath = '/storage/' . $request->file('image')->store('uploads/banners', 'public');
        }

        $banner->update([
            'banner_id' => $request->banner_id,
            'title' => $request->title,
            'image_url' => $imagePath,
            'redirect_url' => $request->redirect_url,
            'position' => $request->position,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Banner updated successfully']);
    }

    // ✅ Delete banner
    public function delete($id)
    {
        $banner = Banner::findOrFail($id);
        if ($banner->image_url && file_exists(public_path($banner->image_url))) {
            unlink(public_path($banner->image_url));
        }
        $banner->delete();

        return response()->json(['message' => 'Banner deleted successfully']);
    }
}
