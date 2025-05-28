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
     * Listar todos los locales visitados por el usuario autenticado
     */
    public function show(Request $request)
    {
        $customerId = $request->user()->customer->id;

        $visitedLocations = $this->visitedLocation
            ->where('customer_id', $customerId)
            ->with(['location'])
            ->get();

        return response()->json($visitedLocations, 200);
    }

    /**
     * Marcar un local como visitado por el usuario autenticado
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'location_id' => 'required|exists:locations,id',
            'review' => 'nullable|string|max:255',
        ]);

        $data['customer_id'] = $request->user()->customer->id; // Obtiene el customer_id del usuario autenticado

        $visitedLocation = $this->visitedLocation->create($data);

        return response()->json([
            'message' => 'Local marcado como visitado.',
            'data' => $visitedLocation->load(['customer', 'location'])
        ], 201);
    }

    /**
     * Actualizar la reseña de un local visitado por el usuario autenticado
     */
    public function update(Request $request)
    {
        $customerId = $request->user()->customer->id;

        $data = $request->validate([
            'review' => 'nullable|string|max:255',
        ]);

        $visitedLocation = $this->visitedLocation->where('customer_id', $customerId)->firstOrFail();
        $visitedLocation->update($data);

        return response()->json([
            'message' => 'Reseña actualizada con éxito.',
            'data' => $visitedLocation->load(['location'])
        ], 200);
    }

    /**
     * Eliminar un local visitado por el usuario autenticado
     */
    public function destroy(Request $request)
    {
        $customerId = $request->user()->customer->id;

        $visitedLocation = $this->visitedLocation->where('customer_id', $customerId)->firstOrFail();
        $visitedLocation->delete();

        return response()->json(['message' => 'Local eliminado de la lista de visitados'], 200);
    }
}
