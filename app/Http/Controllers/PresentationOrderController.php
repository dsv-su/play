<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PresentationOrderController extends Controller
{
    public function show()
    {
        $componentLabels = [
            'home.newpresentations' => 'New on Play Presentations',
            'home.mypresentations' => 'My Presentations',
            'home.studypresentations' => 'Study Presentations',
        ];

        return view('cookie.profile',['componentLabels' => $componentLabels]);
    }

    public function store(Request $request)
    {
        // Allowed components (same as in your Blade)
        $defaultOrder = ['home.newpresentations', 'home.mypresentations', 'home.studypresentations'];

        // Validate and sanitize input
        $data = $request->validate([
            'order'   => 'required|array',
            'order.*' => 'string',
        ]);

        // Keep only allowed components and preserve order
        $order = collect($data['order'])
            ->filter(fn ($c) => in_array($c, $defaultOrder, true))
            ->values()
            ->all();

        // Ensure all defaults appear, same logic as in your Blade
        $order = array_values(array_unique(array_merge($order, $defaultOrder)));

        // Encode as JSON for the cookie
        $json = json_encode($order);

        // Cookie lifetime (e.g. 30 days)
        $minutes = 60 * 24 * 30;

        // If you’re calling this via AJAX, return JSON
        return response()->json([
            'status' => 'ok',
            'order'  => $order,
        ])->cookie('presentation_order', $json, $minutes);
    }
}
