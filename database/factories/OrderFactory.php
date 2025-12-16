<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $shippingCost = $this->faker->numberBetween(15000, 50000);
        $totalItems  = $this->faker->numberBetween(1, 5);
        $itemsTotal  = $this->faker->numberBetween(100000, 3000000);

        return [
            'user_id' => User::query()->inRandomOrder()->value('id')
                ?? User::factory(),

            'order_number' => 'ORD-' . strtoupper(Str::random(10)),

            'total_amount' => $itemsTotal + $shippingCost,
            'shipping_cost' => $shippingCost,

            'status' => $this->faker->randomElement([
                'pending',
                'paid',
                'processing',
                'shipped',
                'completed',
                'cancelled',
            ]),

            'shipping_name' => $this->faker->name,
            'shipping_phone' => $this->faker->phoneNumber,
            'shipping_address' => $this->faker->address,

            'notes' => $this->faker->optional()->sentence,
            'created_at' => now()->subDays(rand(1, 30)),
            'updated_at' => now(),
        ];
    }
        public function pending(): static
        {
            return $this->state([
                'status' => 'pending',
            ]);
        }

    public function paid(): static
    {
        return $this->state([
            'status' => 'paid',
        ]);
    }

    public function completed(): static
    {
        return $this->state([
            'status' => 'completed',
        ]);
    }

    public function cancelled(): static
    {
        return $this->state([
            'status' => 'cancelled',
        ]);
    }
}
