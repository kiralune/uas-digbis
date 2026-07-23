<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Event::class, 'event');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user?->role === 'organizer' && ! $user?->organization_id) {
            abort(403, 'Akun organizer belum terhubung ke organisasi.');
        }

        // Memakai relasi dan pengaturan limit paginasi (10 entri per halaman)
        $query = Event::with('category');

        if ($user?->role === 'organizer') {
            $query->where('organization_id', $user->organization_id);
        }

        $events = $query->latest()->paginate(10);
        return view('organizer.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('organizer.events.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user?->role === 'organizer' && ! $user?->organization_id) {
            abort(403, 'Akun organizer belum terhubung ke organisasi.');
        }

        // Menerapkan validasi data request dari pengguna
        $rules = [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:1',
            'poster' => 'nullable|image|max:2048' //Maksimal 2MB
        ];

        if ($user?->role === 'superadmin') {
            $rules['organization_id'] = 'required|exists:organizations,id';
        }

        $data = $request->validate($rules);

         if ($request->hasFile('poster')) {
        // Simpan ke direktori storage/app/public/posters
        $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        // Menyimpan data yang telah divalidasi ke dalam tabel menggunakan Model
        if ($user?->role === 'organizer') {
            $data['organization_id'] = $user->organization_id;
        }

        Event::create($data);

        return redirect()->route('organizer.events.index')->with('success', 'Data Event berhasil ditambahkan.');
}


    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $categories = \App\Models\Category::all();
        return view('organizer.events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:1',
            'poster' => 'nullable|image|max:2048' //Maksimal 2MB
        ]);
    
        if ($request->hasFile('poster')) {
            // Hapus gambar lama jika sebelumnya sudah memiliki poster
            if ($event->poster_path) {
            
        \Illuminate\Support\Facades\Storage::disk('public')->delete($event->poster_path);
        }
        // Upload gambar baru
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        $event->update($data);
            return redirect()->route('organizer.events.index')->with('success', 'Event berhasil diperbarui.');
        }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Hapus file gambar dari storage jika ada
        if ($event->poster_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($event->poster_path);
        }
        
        $event->delete();
        return redirect()->route('organizer.events.index')->with('success', 'Data event berhasil dihapus secara permanen.');
    }
}
