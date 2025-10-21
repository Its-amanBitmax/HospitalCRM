<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        return view('admin.banner');
    }

    public function store(Request $request)
    {
        $request->validate([
            'banner_id' => 'required|integer|unique:banners,banner_id',
            'title' => 'required|string|max:150',
            'image_url' => 'required|string|max:255',
            'redirect_url' => 'required|string|max:255',
            'position' => 'required|in:Top,Sidebar,Bottom,HomePage',
            'status' => 'required|in:Active,Inactive',
        ]);

        Banner::create([
            'banner_id' => $request->banner_id,
            'title' => $request->title,
            'image_url' => $request->image_url,
            'redirect_url' => $request->redirect_url,
            'position' => $request->position,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Banner added successfully']);
    }

    public function getBanners()
    {
        $banners = Banner::all();
        return response()->json($banners);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'banner_id' => 'required|integer|unique:banners,banner_id,' . $id,
            'title' => 'required|string|max:150',
            'image_url' => 'required|string|max:255',
            'redirect_url' => 'required|string|max:255',
            'position' => 'required|in:Top,Sidebar,Bottom,HomePage',
            'status' => 'required|in:Active,Inactive',
        ]);

        $banner = Banner::findOrFail($id);
        $banner->update([
            'banner_id' => $request->banner_id,
            'title' => $request->title,
            'image_url' => $request->image_url,
            'redirect_url' => $request->redirect_url,
            'position' => $request->position,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Banner updated successfully']);
    }

    public function delete($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();

        return response()->json(['message' => 'Banner deleted successfully']);
    }
}
