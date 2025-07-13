<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KpiFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titulo' => fake()->randomElement([
                'Vendas do Dia',
                'Visitas do Site',
                'Novos Usuários',
                'Pedidos Finalizados',
            ]),
            'valor' => fake()->randomFloat(2, 100, 10000),
            'variacao_percentual' => fake()->randomFloat(2, -10, 10),
        ];
    }
}
