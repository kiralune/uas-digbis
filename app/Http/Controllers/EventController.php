<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;

class EventController extends Controller
{
    function index(){
    
    }

    public function show(\App\Models\Event $event)
    {
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
            ->latest()
            ->get();

        return view('ticket', compact('categories', 'transactions'));
    }
}
