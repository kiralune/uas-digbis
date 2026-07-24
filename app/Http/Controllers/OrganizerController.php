<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Support\Carbon;

class OrganizerController extends Controller
{
    public function show(Organization $organizer)
    {
        $organizer->load([
            'events.category',
            'reviews' => function ($query) {
                $query->latest('submitted_at')->with(['event', 'transaction']);
            },
        ]);

        $eventCount = $organizer->events->count();
        $reviewCount = $organizer->reviews->count();
        $averageRating = $reviewCount ? round((float) $organizer->reviews->avg('rating'), 1) : 0;
        $ticketsSold = $organizer->transactions()->count();

        $upcomingEventsCount = $organizer->events->where('date', '>=', Carbon::now())->count();
        $pastEventsCount = $organizer->events->where('date', '<', Carbon::now())->count();

        return view(
            'organizer.show',
            compact(
                'organizer',
                'eventCount',
                'reviewCount',
                'averageRating',
                'ticketsSold',
                'upcomingEventsCount',
                'pastEventsCount'
            )
        );
    }
}
