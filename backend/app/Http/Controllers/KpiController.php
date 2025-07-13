<?php

namespace App\Http\Controllers;

use App\Models\Kpi;
use Illuminate\Http\Request;

class KpiController extends Controller
{
    public function index()
    {
        return response()->json(Kpi::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'variacao_percentual' => 'required|numeric',
        ]);

        $kpi = Kpi::create($validated);

        return response()->json($kpi, 201);
    }

    public function show(Kpi $kpi)
    {
        return response()->json($kpi);
    }

    public function update(Request $request, Kpi $kpi)
    {
        $validated = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'valor' => 'sometimes|required|numeric',
            'variacao_percentual' => 'sometimes|required|numeric',
        ]);

        $kpi->update($validated);

        return response()->json($kpi);
    }

    public function destroy(Kpi $kpi)
    {
        $kpi->delete();

        return response()->json(null, 204);
    }
}
