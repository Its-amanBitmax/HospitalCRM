<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;

class AdminProfileController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if ($request->form_type === 'organization') {
            $request->validate([
                'hospital_name' => 'nullable|string|max:255',
                'company_address' => 'nullable|string',
                'company_contact' => 'nullable|string|max:255',
                'company_email' => 'nullable|email',
                'company_website' => 'nullable|url',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $updateData = $request->only(['hospital_name', 'company_address', 'company_contact', 'company_email', 'company_website']);

            // Handle logo upload
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($admin->logo && Storage::disk('public')->exists($admin->logo)) {
                    Storage::disk('public')->delete($admin->logo);
                }

                $logo = $request->file('logo');
                $logoName = time() . '_logo_' . $logo->getClientOriginalName();
                $logoPath = $logo->storeAs('logos', $logoName, 'public');
                $updateData['logo'] = $logoPath;
            }

            $admin->update($updateData);

            return redirect()->back()->with('success', 'Organization information updated successfully.');
        } else {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:admins,email,' . $admin->id,
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $updateData = $request->only(['name', 'email']);

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                // Delete old profile image if exists
                if ($admin->profile_image && Storage::disk('public')->exists($admin->profile_image)) {
                    Storage::disk('public')->delete($admin->profile_image);
                }

                $profileImage = $request->file('profile_image');
                $profileImageName = time() . '_profile_' . $profileImage->getClientOriginalName();
                $profileImagePath = $profileImage->storeAs('profile_images', $profileImageName, 'public');
                $updateData['profile_image'] = $profileImagePath;
            }

            $admin->update($updateData);

            return redirect()->back()->with('success', 'Profile updated successfully.');
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $admin = Auth::guard('admin')->user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password changed successfully.');
    }

    public function patientRegistration()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.patient-registration', compact('admin'));
    }
}
