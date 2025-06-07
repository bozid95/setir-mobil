<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::create([
            'name' => 'Basic Package',
            'description' => 'Basic driving lessons for beginners - 4 weeks duration',
            'price' => 1500000,
        ]);

        Package::create([
            'name' => 'Standard Package',
            'description' => 'Comprehensive driving training - 6 weeks duration',
            'price' => 2500000,
        ]);

        Package::create([
            'name' => 'Premium Package',
            'description' => 'Premium driving course with advanced training - 8 weeks duration',
            'price' => 3500000,
        ]);
    }
}
