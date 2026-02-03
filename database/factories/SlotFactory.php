<?php

namespace Database\Factories;

use App\Models\Slot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slot>
 */
class SlotFactory extends Factory
{
	protected $model = Slot::class;
	
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
		$capacity = RAND(1,10);
		
        return [
            'capacity' => $capacity,
			'remaining' => RAND(0, $capacity)
        ];
    }
}
