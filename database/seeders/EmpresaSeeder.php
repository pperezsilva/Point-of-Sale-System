<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empresa::insert([
            [
                'nombre' => 'Cartroks',
                'propietario' => 'Pedro Perez',
                'ruc' => '123456789',
                'porcentaje_impuesto' => '15',
                'abreviatura_impuesto' => 'IGV',
                'direccion' => 'Av. 1',
                'moneda_id' => 3
            ]
        ]);
    }
}
