<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TravelInquiry;

class TravelInquiryController extends Controller
{
    public function travel()
    {
        return view('travelInquiry.travel');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'destination' => 'required',
            'travel_date' => 'required|date',
        ]);

        TravelInquiry::create([
            'username' => $request->username,
            'phone' => $request->phone,
            'email' => $request->email,
            'destination' => $request->destination,
            'travel_date' => $request->travel_date,
        ]);

        return redirect()->back()->with('success', 'Travel inquiry submitted successfully!');
    }
}