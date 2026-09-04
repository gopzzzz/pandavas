<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToursController extends Controller
{
    // LIST
    public function index()
    {
        $tours = DB::table('tours')
            ->orderBy('id', 'asc')
            ->get();

        return view('tours', compact('tours'));
    }


    // ADD
    public function store(Request $request)
    {
        $request->validate([
            'tourname' => 'required|string|max:150',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
            'features' => 'required|string',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'total_seats' => 'required|integer|min:1',
            'date' => 'required|date',
            'time' => 'required',
            'pickuplocations' => 'required|string|max:255',
        ]);

        $uploadPath = public_path('uploads/tours');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $imageName = time() . '_' . $request->image->getClientOriginalName();

        $request->image->move($uploadPath, $imageName);

        DB::table('tours')->insert([
            'tourname' => $request->tourname,
            'image' => $imageName,
            'features' => $request->features,
            'description' => $request->description,
            'amount' => $request->amount,
            'total_seats' => $request->total_seats,
            'date' => $request->date,
            'time' => $request->time,
            'pickuplocations' => $request->pickuplocations,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('tours.index')
            ->with('success', 'Tour added successfully.');
    }


    // EDIT / UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'tourname' => 'required|string|max:150',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'features' => 'required|string',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'total_seats' => 'required|integer|min:1',
            'date' => 'required|date',
            'time' => 'required',
            'pickuplocations' => 'required|string|max:255',
        ]);

        $tour = DB::table('tours')
            ->where('id', $id)
            ->first();

        if (!$tour) {
            return redirect()->route('tours.index')
                ->with('error', 'Tour not found.');
        }

        $imageName = $tour->image;

        // Replace old image
        if ($request->hasFile('image')) {

            if ($tour->image) {
                $oldImage = public_path('uploads/tours/' . $tour->image);

                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            $uploadPath = public_path('uploads/tours');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $imageName = time() . '_' . $request->image->getClientOriginalName();

            $request->image->move($uploadPath, $imageName);
        }

        DB::table('tours')
            ->where('id', $id)
            ->update([
                'tourname' => $request->tourname,
                'image' => $imageName,
                'features' => $request->features,
                'description' => $request->description,
                'amount' => $request->amount,
                'total_seats' => $request->total_seats,
                'date' => $request->date,
                'time' => $request->time,
                'pickuplocations' => $request->pickuplocations,
                'updated_at' => now(),
            ]);

        return redirect()->route('tours.index')
            ->with('success', 'Tour updated successfully.');
    }
}