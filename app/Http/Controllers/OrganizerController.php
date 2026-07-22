<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Event;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    public function show(Organization $organization)
    {
        $events = Event::with('category')
            ->where('organization_id', $organization->id)
            ->where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->get();

        return view('organizers.show', compact('organization', 'events'));
    }
}
