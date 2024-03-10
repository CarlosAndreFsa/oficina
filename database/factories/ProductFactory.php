<?php

namespace Database\Factories;

use App\Models\{Brand, Category, Product};
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'category_id' => CategoryFactory::new(),
            'brand_id'    => BrandFactory::new(),
            'name'        => $this->faker->name(),
            'description' => $this->faker->text(400),
            'price'       => $this->faker->randomFloat(2, 100, 9000),
            'stock'       => $this->faker->numberBetween(0, 100),
            'cover'       => 'https://picsum.photos/400?x=' . mt_rand(),
        ];
    }
}
