<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TravelInquiry;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Log;

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
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255',
            'tags' => 'required',
            'destination' => 'required|alpha',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ], [
            'title.required' => 'The title field is required.',
            'title.min' => 'The title must be at least :min characters.',
            'title.max' => 'The title may not be greater than :max characters.',
            'tags.required' => 'The tags field is required.',
            'destination.required' => 'The destination field is required.',
            'destination.alpha' => 'The destination must only contain alphabetic characters.',
            'start_date.required' => 'The start date field is required.',
            'start_date.date' => 'The start date must be a valid date.',
            'end_date.required' => 'The end date field is required.',
            'end_date.date' => 'The end date must be a valid date.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
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

    public function searchMap(Request $request)
    {
        //$geoCode_HKG = $this->geocode("Hong Kong");
        if ($request->ajax()) {
            $param = $request->get('query');
            $startPoint = $request->get('startPoint');
            $geoCode_HKG = $this->geocode($startPoint);
            $geoCode_dest = $this->geocode($param);
            $response = [
                'query' => $param,
                'geocode' => $geoCode_dest,
                'hongKongGeocode' => $geoCode_HKG,
            ];

            return response()->json($response);
        }
    }

    //Query the latitude, longitude of an address from Google Maps Geocoding API
    public function geocode($address)
    {

        // url encode the address
        $address = urlencode($address);

        // apply your google map api key here
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyDJQqiwokQWGGBEvgP_BMD8_w9TpeC5tjc";

        // get the json response
        $resp_json = file_get_contents($url);

        // decode the json
        $resp = json_decode($resp_json, true);

        // response status will be 'OK', if able to geocode given address 
        if ($resp['status'] == 'OK') {

            // get the important data
            $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
            $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";

            // verify if data is complete
            if ($lati && $longi) {

                // put the data in the array
                $data_arr = array();

                array_push(
                    $data_arr,
                    $lati,
                    $longi
                );

                return $data_arr;
            } else {
                return false;
            }
        }
    }

    public function destroy($id)
    {
        TravelInquiry::destroy($id);

        return redirect()->route('travelInquiry.index')->with('success', 'Travel inquiry deleted successfully!');
    }
}