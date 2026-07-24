<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $organizer = $user->organization;

        abort_unless($organizer, 403, 'Organizer tidak ditemukan.');

        return view('organizer.profile.edit', compact('organizer'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $organizer = $user->organization;

        abort_unless($organizer, 403, 'Organizer tidak ditemukan.');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Regenerate slug if name changes
        if ($validated['name'] !== $organizer->name) {
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $counter = 1;

            while (Organization::where('slug', $slug)->where('id', '!=', $organizer->id)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }

            $validated['slug'] = $slug;
        }

        // Handle logo upload
        if ($request->hasFile('logo_url')) {
            // Delete old logo if exists
            if ($organizer->logo_url && Storage::disk('public')->exists($organizer->logo_url)) {
                Storage::disk('public')->delete($organizer->logo_url);
            }

            // Store new logo
            $path = $request->file('logo_url')->store('organizer-logos', 'public');
            $validated['logo_url'] = Storage::url($path);
        }

        $organizer->update($validated);

        return redirect()->route('organizer.profile.edit')->with('success', 'Profil organizer berhasil diperbarui.');
    }
}
