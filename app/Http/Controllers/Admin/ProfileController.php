<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile', ['profile' => Profile::current()]);
    }

    public function update(Request $request)
    {
        $profile = Profile::current();

        $data = $request->validate([
            'name' => 'required|max:100',
            'headline' => 'nullable|max:150',
            'availability' => 'nullable|max:200',
            'about' => 'nullable|max:5000',
            'email' => 'nullable|email|max:150',
            'github' => 'nullable|url|starts_with:http://,https://|max:255',
            'linkedin' => 'nullable|url|starts_with:http://,https://|max:255',
            'instagram' => 'nullable|url|starts_with:http://,https://|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cv' => 'nullable|mimes:pdf|max:5120',
        ]);

        unset($data['photo'], $data['cv']);

        if ($request->hasFile('photo')) {
            if ($profile->photo) Storage::disk('public')->delete($profile->photo);
            $data['photo'] = $request->file('photo')->store('profile', 'public');
        }
        if ($request->hasFile('cv')) {
            if ($profile->cv) Storage::disk('public')->delete($profile->cv);
            $data['cv'] = $request->file('cv')->store('profile', 'public');
        }

        $profile->update($data);
        return back()->with('success', 'Profil diperbarui');
    }
}
