<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kpi;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 🔒 Usuário admin fixo
        User::factory()->admin()->create();

        // 👤 Usuários aleatórios (opcional)
        User::factory(5)->create();

        // 📊 KPIs fixos (um de cada tipo)
        Kpi::factory()->create(['titulo' => 'Vendas do Dia']);
        Kpi::factory()->create(['titulo' => 'Visitas do Site']);
        Kpi::factory()->create(['titulo' => 'Novos Usuários']);
        Kpi::factory()->create(['titulo' => 'Pedidos Finalizados']);
    }
}
