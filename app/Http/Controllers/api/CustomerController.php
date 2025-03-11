<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{

    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = $this->customer->all();
        return response()->json($customers, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:255',
            'role' => 'required|string|max:255',
        ]);

        $perfil = $this->customer->create($data);
        return response()->json($perfil, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->customer->findOrFail($id);
        return response()->json($result, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:255',
            'role' => 'required|string|max:255'
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'password.required' => 'El campo contraseña es obligatorio',
            'role.required' => 'El campo rol es obligatorio'
        ]);

        $result = $this->customer->findOrFail($id);
        $result->update($data);
        return response()->json(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->customer->findOrFail($id);
        $result->delete();
        return response()->json(null, 204);
    }
}
