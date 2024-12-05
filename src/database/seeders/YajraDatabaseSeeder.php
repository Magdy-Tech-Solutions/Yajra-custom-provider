<?php

namespace Database\Seeders;

use App\Models\User;
use Custom\Yajra\Models\Yajra;
use Illuminate\Database\Seeder;

class YajraDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Yajra::create([
            'title' => 'this is title',
            'description' => 'this is description',
        ]);
    }
}
