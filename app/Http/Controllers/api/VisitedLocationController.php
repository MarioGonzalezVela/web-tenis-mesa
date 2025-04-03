<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisitedLocation;

class VisitedLocationController extends Controller
{
    protected $visitedLocation;

    public function __construct(VisitedLocation $visitedLocation)
    {
        $this->visitedLocation = $visitedLocation;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visitedLocations = $this->visitedLocation->with(['customer', 'location'])->get();
        return response()->json($visitedLocations, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'location_id' => 'required|exists:locations,id',
            'review' => 'nullable|string|max:255',
        ]);

        $visitedLocation = $this->visitedLocation->create($data);
        return response()->json($visitedLocation, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $visitedLocation = $this->visitedLocation->with(['customer', 'location'])->findOrFail($id);
        return response()->json($visitedLocation, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'location_id' => 'required|exists:locations,id',
            'review' => 'nullable|string|max:255',
        ]);

        $visitedLocation = $this->visitedLocation->findOrFail($id);
        $visitedLocation->update($data);
        return response()->json($visitedLocation, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $visitedLocation = $this->visitedLocation->findOrFail($id);
        $visitedLocation->delete();
        return response()->json(null, 204);
    }
}
