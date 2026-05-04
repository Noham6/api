<?php

namespace App\Http\Controllers;

use App\Models\Espece;
use Illuminate\Http\Request;

class EspeceController extends Controller
{
    public function index()
    {
        return response()->json(Espece::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle'         => 'required|string|max:255|unique:especes,libelle',
            'temperature_min' => 'nullable|numeric',
            'temperature_max' => 'nullable|numeric',
            'humidite_min'    => 'nullable|numeric|min:0|max:100',
            'humidite_max'    => 'nullable|numeric|min:0|max:100',
            'description'     => 'nullable|string',
        ]);
        $espece = Espece::create($validated);
        return response()->json($espece, 201);
    }

    public function update(Request $request, $id)
    {
        $espece = Espece::findOrFail($id);
        $validated = $request->validate([
            'libelle'         => 'sometimes|string|max:255|unique:especes,libelle,' . $id,
            'temperature_min' => 'nullable|numeric',
            'temperature_max' => 'nullable|numeric',
            'humidite_min'    => 'nullable|numeric|min:0|max:100',
            'humidite_max'    => 'nullable|numeric|min:0|max:100',
            'description'     => 'nullable|string',
        ]);
        $espece->update($validated);
        return response()->json($espece);
    }

    public function destroy($id)
    {
        $espece = Espece::findOrFail($id);
        $espece->delete();
        return response()->json(['message' => 'Espèce supprimée']);
    }
}
