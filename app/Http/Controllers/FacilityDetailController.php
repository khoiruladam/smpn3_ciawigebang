<?php

namespace App\Http\Controllers;

use App\Models\Facility;

class FacilityDetailController extends Controller
{
    public function show(Facility $facility)
    {
        if (!$facility->is_published) {
            abort(404);
        }

        $facility->load('images');

        return view('facilities.show', compact('facility'));
    }
}