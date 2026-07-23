<?php

namespace App\Http\Controllers;

use App\Models\Partners;

class OrganizerController extends Controller
{
    public function show(Partners $partner)
    {
        $partner->load(['events.category', 'reviews' => function ($query) {
            $query->latest('submitted_at');
        }]);

        $averageRating = round((float) $partner->reviews()->avg('rating'), 1);
        $reviewCount = $partner->reviews()->count();

        return view('organizers.show', compact('partner', 'averageRating', 'reviewCount'));
    }
}
