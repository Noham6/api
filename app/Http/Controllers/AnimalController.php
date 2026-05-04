<?php

namespace App\Http\Controllers;

use App\Models\Animaux;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    // GET /animaux — liste des animaux du propriétaire connecté
    public function index(Request $request)
    {
        $animaux = Animaux::with('espece', 'proprietaire')
            ->where('user_id', $request->user()->id)
            ->get();
        return response()->json($animaux);
    }

    // GET /animaux/{id}
    public function show(Request $request, $id)
    {
        $animal = Animaux::with('espece', 'proprietaire')
            ->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();
        if (!$animal) return response()->json(['message' => 'Animal non trouvé'], 404);
        return response()->json($animal);
    }

    // POST /animaux
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'                => 'required|string|max:255',
            'espece_id'          => 'nullable|exists:especes,id',
            'race'               => 'nullable|string|max:255',
            'age'                => 'nullable|integer|min:0',
            'poids'              => 'nullable|numeric|min:0',
            'description'        => 'nullable|string',
            'carnet_vaccination' => 'nullable|boolean',
            'vaccin_a_jour'      => 'nullable|boolean',
            'vermifuge_a_jour'   => 'nullable|boolean',
        ]);
        $validated['user_id'] = $request->user()->id;
        $animal = Animaux::create($validated);
        return response()->json($animal->load('espece', 'proprietaire'), 201);
    }

    // PUT /animaux/{id}
    public function update(Request $request, $id)
    {
        $animal = Animaux::where('id', $id)->where('user_id', $request->user()->id)->first();
        if (!$animal) return response()->json(['message' => 'Animal non trouvé'], 404);

        $validated = $request->validate([
            'nom'                => 'sometimes|string|max:255',
            'espece_id'          => 'nullable|exists:especes,id',
            'race'               => 'nullable|string|max:255',
            'age'                => 'nullable|integer|min:0',
            'poids'              => 'nullable|numeric|min:0',
            'description'        => 'nullable|string',
            'carnet_vaccination' => 'nullable|boolean',
            'vaccin_a_jour'      => 'nullable|boolean',
            'vermifuge_a_jour'   => 'nullable|boolean',
        ]);
        $animal->update($validated);
        return response()->json($animal->load('espece', 'proprietaire'));
    }

    // DELETE /animaux/{id}
    public function destroy(Request $request, $id)
    {
        $animal = Animaux::where('id', $id)->where('user_id', $request->user()->id)->first();
        if (!$animal) return response()->json(['message' => 'Animal non trouvé'], 404);
        $animal->delete();
        return response()->json(['message' => 'Animal supprimé avec succès']);
    }

    // PUT /animaux/{id}/proprietaire — changer le propriétaire (pension uniquement)
    public function changeProprietaire(Request $request, $id)
    {
        $animal = Animaux::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $animal->update(['user_id' => $validated['user_id']]);
        return response()->json($animal->load('espece', 'proprietaire'));
    }
}
