<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lot;
use App\Models\Block;
use App\Models\Lots;
use App\Models\LotsCategory;
use App\Models\LotsType;

class LotsSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Get related data IDs
        $blocks = Block::pluck('id')->toArray();
        $categories = LotsCategory::pluck('id')->toArray();
        $types = LotsType::pluck('id')->toArray();

        // ✅ Safety check
        if (empty($blocks) || empty($categories) || empty($types)) {
            $this->command->error('⚠️ Please seed Blocks, Categories, and Types before running LotsSeeder.');
            return;
        }

        // ✅ Define possible statuses and listing types
        $statuses = ['available', 'sold', 'reserved'];
        $listingTypes = ['for_sale', 'for_rent'];

        // ✅ Create 147 lots
        foreach (range(1, 154) as $i) {
            Lots::create([
                'block_id'      => $blocks[array_rand($blocks)],
                'category_id'   => $categories[array_rand($categories)],
                'type_id'       => $types[array_rand($types)],
                'lot_name'      => 'Lot ' . $i,
                'area'          => rand(80, 300),
                'price'         => rand(500000, 2000000),
                'listing_type'  => $listingTypes[array_rand($listingTypes)], // 👈 NEW
                'status'        => $statuses[array_rand($statuses)],
                'description'   => 'This is a sample description for Lot ' . $i,
                'position'      => null, // optional placeholder
            ]);
        }

        $this->command->info('✅ 154 lots seeded successfully (with listing_type).');
    }
}
