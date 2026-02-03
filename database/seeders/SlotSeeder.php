<?php

namespace Database\Seeders;

use App\Models\Slot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//use Database\Factories\SlotFactory;

class SlotSeeder extends Seeder
{
    
    /**
     * Seed the application's database.
	 * php artisan db:seed --class=SlotSeeder
     */
    public function run(): void
    {
        $slots = Slot::factory()->count(15)->create();
    }
}
