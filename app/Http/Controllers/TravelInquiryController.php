<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TravelInquiry;
use App\Models\Tag;

class TravelInquiryController extends Controller
{
    public function travel()
    {
        return view('travelInquiry.travel');
    }
    public function searchResults(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $searchOption = $request->input('searchOption');

        // Perform the search query based on the search term and option
        if ($searchOption === 'destination') {
            $inquiries = TravelInquiry::where('destination', 'like', '%' . $searchTerm . '%')->get();
        } elseif ($searchOption === 'tags') {
            $inquiries = TravelInquiry::where('tags', 'like', '%' . $searchTerm . '%')->get();
        } else {
            $inquiries = collect(); // Empty collection if the search option is not recognized
        }

        $totalRecords = $inquiries->count();

        return view('search_results', compact('inquiries', 'totalRecords'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'tags' => 'required',
            'destination' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // Serialize the array of tags into a string
        $tags = implode(',', $request->tags);

        TravelInquiry::create([
            'title' => $request->title,
            'tags' => $tags, // Assign the serialized tags string
            'destination' => $request->destination,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        // Rest of your code...

        return redirect()->back()->with('success', 'Travel inquiry submitted successfully!');
    }

    public function index()
    {
        $travelInquiries = TravelInquiry::all();
        return view('index', compact('travelInquiries'));
    }
    public function edit(int $id)
    {
        $travelInquiry = TravelInquiry::find($id);
        return view('travelInquiry.edit', compact('travelInquiry'));
    }

    public function update(Request $request, int $id)
    {
        // 1. Validate the inputted data
        $request->validate([
            'title' => 'required',
            'tags' => 'required',
            'destination' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        // 2. Search the travel inquiry from the database
        $travelInquiry = TravelInquiry::find($id);

        // 3. Set the new values
        $travelInquiry->title = $request->get('title');
        $travelInquiry->tags = $request->get('tags');
        $travelInquiry->destination = $request->get('destination');
        $travelInquiry->start_date = $request->get('start_date');
        $travelInquiry->end_date = $request->get('end_date');

        // 4. Save the travel inquiry into the database
        $travelInquiry->save();

        return redirect()->route('travelInquiry.index')->with('success', 'Travel inquiry updated successfully!');
    }

    public function destroy($id)
    {
        TravelInquiry::destroy($id);

        return redirect()->route('travelInquiry.index')->with('success', 'Travel inquiry deleted successfully!');
    }
}
