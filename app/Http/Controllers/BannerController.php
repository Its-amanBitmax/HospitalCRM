<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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

    // ✅ Move file directly to public/uploads/banners
    $image = $request->file('image');
    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
    $image->move(public_path('uploads/banners'), $filename);

    Banner::create([
        'banner_id' => $request->banner_id,
        'title' => $request->title,
        'image_url' => $filename, // only filename saved
        'redirect_url' => $request->redirect_url,
        'position' => $request->position,
        'status' => $request->status,
    ]);

    return response()->json(['message' => 'Banner added successfully']);
}


    // ✅ Fetch all banners
    public function getBannersApi()
    {
        $banners = Banner::all();
        $banners = $banners->map(function($banner) {
            return [
                'banner_id' => $banner->banner_id,
                'title' => $banner->title,
                'image_url' => '/uploads/banners/' . $banner->image_url,
                'redirect_url' => $banner->redirect_url,
                'position' => $banner->position,
                'status' => $banner->status,
            ];
        });
        return response()->json($banners);
    }
    
     public function getBanners()
    {
        $banners = Banner::all();
        $banners = $banners->map(function($banner) {
            return [
                'banner_id' => $banner->banner_id,
                'title' => $banner->title,
                'image_url' => '/uploads/banners/' . $banner->image_url,
                'redirect_url' => $banner->redirect_url,
                'position' => $banner->position,
                'status' => $banner->status,
            ];
        });
        return response()->json($banners);
    }


public function update(Request $request, $id)
{
    // ✅ Fetch banner using banner_id, not id
    $banner = Banner::where('banner_id', $id)->firstOrFail();

    // ✅ Validation using Rule::unique — ignore current banner_id
    $request->validate([
        'banner_id' => [
            'required',
            'string',
            Rule::unique('banners', 'banner_id')->ignore($id, 'banner_id'),
        ],
        'title' => 'required|string|max:150',
        'redirect_url' => 'required|string|max:255',
        'position' => 'required|in:Top,Sidebar,Bottom,HomePage',
        'status' => 'required|in:Active,Inactive',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    $filename = $banner->image_url;

    // ✅ If new image uploaded
    if ($request->hasFile('image')) {
        $oldPath = public_path('uploads/banners/' . $banner->image_url);
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }

        $image = $request->file('image');
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/banners'), $filename);
    }

    // ✅ Update the banner
    $banner->update([
        'banner_id' => $request->banner_id,
        'title' => $request->title,
        'image_url' => $filename,
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
    $path = public_path('uploads/banners/' . $banner->image_url);

    if (file_exists($path)) {
        unlink($path);
    }

    $banner->delete();

    return response()->json(['message' => 'Banner deleted successfully']);
}


}
