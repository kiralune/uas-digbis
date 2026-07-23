<?php

namespace App\Http\Controllers;

use App\Models\Partners;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        if ($search) {
            $partners = Partners::where('name', 'LIKE', '%' . $search . '%')->get();
        } else {
            $partners = Partners::all();
        }
        
        return view('organizer.partners.index', compact('partners', 'search'));
    }

    public function create()
    {
        return view('organizer.partners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'required|url|max:255',
        ]);

        Partners::create($validated);

        return redirect()->route('organizer.partners.index')->with('success', 'Partner berhasil ditambahkan!');
    }

    public function edit(Partners $partner)
    {
        return view('organizer.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partners $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'required|url|max:255',
        ]);

        $partner->update($validated);

        return redirect()->route('organizer.partners.index')->with('success', 'Partner berhasil diperbarui!');
    }

    public function destroy(Partners $partner)
    {
        $partner->delete();
        return redirect()->route('organizer.partners.index')->with('success', 'Partner berhasil dihapus!');
    }
}
