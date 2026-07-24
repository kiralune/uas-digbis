<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Event::with(['category', 'organization', 'partner'])
            ->whereNotNull('organization_id')
            ->whereHas('organization')
            ->orderBy('date', 'asc');

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $events = $query->paginate(12)->withQueryString();

        return view('events.index', compact('events', 'categories'));
    }

    public function show(\App\Models\Event $event)
    {
        // Muat relasi yang dibutuhkan oleh halaman detail event
        $event->load(['category', 'organization']);

        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();
        $event->load('partner');
    
        // Me-render view dengan membawa data kategori dan data spesifik acara tersebut
        return view('event-detail', compact('categories', 'event'));
    }

    function checkout(){
        return view('checkout');
    }

    function ticket(Request $request){
        $categories = \App\Models\Category::all();

        $transactions = Transaction::with(['event.partner', 'review'])
            ->where('customer_email', auth()->user()->email)
            ->latest()
            ->get();

        return view('ticket', compact('categories', 'transactions'));
    }
}
