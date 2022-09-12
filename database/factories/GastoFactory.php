<?php

namespace Database\Factories;

use App\Models\Gasto;
use Illuminate\Database\Eloquent\Factories\Factory;
use Fake\Generator as Faker;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gasto>
 */
class GastoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'usuario_id' => rand(1, 8),
            'categoria_de_gastos_id' => 4,
            'descricao_gasto' => $this->faker->name(),
            'valor_do_gasto' => rand(1, 100000),
            'data_do_gasto' => date('Y-m-d'),
            'dia_do_gasto' => date('d'),
            'mes_do_gasto' => date('m'),
            'ano_do_gasto' =>date('Y'),
            'forma_de_pagamento' => rand(1, 3)

            // php artisan db:seed --class=GastoSeeder
            // DELETE FROM gastos WHERE user_id = 8;
        ];
    }
}
// $factory->define(Gasto::class, function (Faker $faker){
//     return [
//         'user_id' => 1,
//         'usuario_id' => 8,
//         'categoria_de_gasto_id' => 4,
//         'descricao_gasto' => $faker->name(),
//         'valor_do_gasto' =>$this->Str::random(5),
//         'data_do_gasto' => date('Y-m-d'),
//         'dia_do_gasto' => date('d'),
//         'mes_do_gasto' => date('m'),
//         'ano_do_gasto' =>date('Y'),
//         'forma_de_pagamento' => 3
//     ];
// });
