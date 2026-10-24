<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            [
                'name' => 'Size',
                'type' => 'select',
                'sort_order' => 1,
                'values' => [
                    ['name' => 'XS', 'sort_order' => 1],
                    ['name' => 'S', 'sort_order' => 2],
                    ['name' => 'M', 'sort_order' => 3],
                    ['name' => 'L', 'sort_order' => 4],
                    ['name' => 'XL', 'sort_order' => 5],
                    ['name' => 'XXL', 'sort_order' => 6],
                    ['name' => 'Free Size', 'sort_order' => 7],
                ]
            ],
            [
                'name' => 'Colour',
                'type' => 'radio',
                'sort_order' => 2,
                'values' => [
                    ['name' => 'Crimson Red', 'sort_order' => 1],
                    ['name' => 'Royal Navy Blue', 'sort_order' => 2],
                    ['name' => 'Emerald Green', 'sort_order' => 3],
                    ['name' => 'Deep Maroon', 'sort_order' => 4],
                    ['name' => 'Mustard Gold', 'sort_order' => 5],
                    ['name' => 'Pastel Cyan', 'sort_order' => 6],
                    ['name' => 'Jet Black', 'sort_order' => 7],
                ]
            ],
            [
                'name' => 'Fabric',
                'type' => 'select',
                'sort_order' => 3,
                'values' => [
                    ['name' => 'Pure Silk', 'sort_order' => 1],
                    ['name' => 'Banarasi Silk', 'sort_order' => 2],
                    ['name' => 'Royal Velvet', 'sort_order' => 3],
                    ['name' => 'Chanderi Cotton', 'sort_order' => 4],
                    ['name' => 'Georgette', 'sort_order' => 5],
                    ['name' => 'Organza', 'sort_order' => 6],
                ]
            ],
            [
                'name' => 'Occasion',
                'type' => 'checkbox',
                'sort_order' => 4,
                'values' => [
                    ['name' => 'Bridal & Wedding', 'sort_order' => 1],
                    ['name' => 'Festive Celebration', 'sort_order' => 2],
                    ['name' => 'Party & Cocktail', 'sort_order' => 3],
                    ['name' => 'Casual Ethnic', 'sort_order' => 4],
                ]
            ]
        ];

        foreach ($options as $optData) {
            $values = $optData['values'];
            unset($optData['values']);

            $option = Option::firstOrCreate(
                ['name' => $optData['name']],
                $optData
            );

            foreach ($values as $valData) {
                OptionValue::firstOrCreate(
                    [
                        'option_id' => $option->id,
                        'name' => $valData['name']
                    ],
                    [
                        'sort_order' => $valData['sort_order'],
                        'option_value_image' => null
                    ]
                );
            }
        }
    }
}
