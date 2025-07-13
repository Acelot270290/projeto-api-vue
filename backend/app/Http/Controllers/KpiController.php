<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKpiRequest;
use App\Http\Requests\UpdateKpiRequest;
use App\Repositories\KpiRepository;
use Illuminate\Http\JsonResponse;

class KpiController extends Controller
{
    protected KpiRepository $kpiRepository;

    public function __construct(KpiRepository $kpiRepository)
    {
        $this->kpiRepository = $kpiRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->kpiRepository->all());
    }

    public function store(StoreKpiRequest $request): JsonResponse
    {
        $kpi = $this->kpiRepository->create($request->validated());
        return response()->json($kpi, 201);
    }

    public function show(int $id): JsonResponse
    {
        $kpi = $this->kpiRepository->find($id);
        return response()->json($kpi);
    }

    public function update(UpdateKpiRequest $request, int $id): JsonResponse
    {
        $kpi = $this->kpiRepository->update($id, $request->validated());
        return response()->json($kpi);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->kpiRepository->delete($id);
        return response()->json(null, 204);
    }
}
