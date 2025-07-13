<?php
namespace App\Repositories;

use App\Models\Kpi;

class KpiRepository
{
    public function all()
    {
        return Kpi::all();
    }

    public function find(int $id): ?Kpi
    {
        return Kpi::findOrFail($id);
    }

    public function create(array $data): Kpi
    {
        return Kpi::create($data);
    }

    public function update(int $id, array $data): Kpi
    {
        $kpi = Kpi::findOrFail($id);
        $kpi->update($data);
        return $kpi;
    }

    public function delete(int $id): void
    {
        $kpi = Kpi::findOrFail($id);
        $kpi->delete();
    }
}
