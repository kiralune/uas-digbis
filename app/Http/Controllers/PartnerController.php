<?php

namespace App\Http\Controllers;

use App\Models\Partners;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partners::all();
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'required|url|max:255',
        ]);

        Partners::create($validated);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil ditambahkan!');
    }

    public function destroy(Partners $partner)
    {
        $partner->delete();
        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dihapus!');
    }
}
