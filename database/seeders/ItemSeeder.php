<?php

namespace Database\Seeders;

use App\Enum\ItemTypeEnum;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name'  => [
                    'en' => 'Pocket Steamer Puff-x',
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/pocket_steam_gun_x_1.webp',
            ],
            [
                'name'  => [
                    'en' => 'Ritti Cash Machine',
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/cash_register_ritty_1.webp',
            ],
            [
                'name'  => [
                    'en' => 'Lamp With Dust',
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/lamp_dust_1.webp',
            ],
            [
                'name'  => [
                    'en' => 'Golden Leather Cloak',
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/cloak_golden_leather_1.webp',
            ],
            [
                'name'  => [
                    'en' => 'Knight\'s Copper Helm',
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/helmet_copper_missing_knight_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Digger's Jumpsuit",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/jumpsuit_digger_prof_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Digger's Boots",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/boots_digger_leather_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Digger's Gloves",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/gloves_digger_comfortable_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Digger's Gas Mask",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/respirator_digger_homemade_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Miner's Pickaxe",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/pickaxe_lost_miner_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Mine Boss's Coat",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/coat_mine_boss_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Miner's Helmet",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/hat_iron_underground_mod_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Gloves of a Loving Heart",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/gloves_loving_heart_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Mine Boss's Breeches",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/breeches_mine_boss_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Hand Drill",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/drill_lost_hand_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Snip-snip Club",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/mallet_cc_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Rapier Of Retribution",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/rapier_ret_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Double-barreled Menton's Steam Rifle",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/shotgun_steam_men_1.webp',
            ],
            [
                'name'  => [
                    'en' => 'Copper Revolver “samuel”',
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/revolver_cooper_sam_1.webp',
            ],
            [
                'name'  => [
                    'en' => 'Earth Spirits Drum',
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/drum_spirit_ert_1.webp',
            ],
            [
                'name'  => [
                    'en' => 'Widowmaker',
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/widow_maker_1.webp',
            ],
            [
                'name'  => [
                    'en' => 'Quark Cutter',
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/quark_cutter_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Flur Gladius",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/gladius_flur_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Baron Samedi's Coat",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/camisole_baron_samedi_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Perfect flur crystal",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/crystal_perfectly_flure_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Grinch's boots",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/boots_grinch_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Pumpkin Lord Helmet",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/helmet_lord_pumpkins_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Easter bunny pants",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/pants_easter_bunny_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Staff 'Soul of Quark'",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/staff_soul_qrk_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Gloves With Inserts",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/gloves_copper_inserts_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Talkative Cucumber Shooter",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/shotgun_cucumber_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Tin Woodcutter's Axe",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/axe_iron_woodman_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Heavy jacket",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/jacket_heavy_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Steam lantern",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/lantern_steam_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Spyglass",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/spyglass_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Wristwatch",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/wristwatch_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Hydraulic Boots",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/boots_hydraulic_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Copper Wheel",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/wheel_copper_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Worm's Armor",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/armor_worm_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Eye of Terror",
                ],
                'type'  => ItemTypeEnum::EQUIPMENT->value,
                'image' => 'resources/images/items/eye_horror_1.webp',
            ],

            [
                'name'  => [
                    'en' => "Scrap cloth",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_scrap_cloth_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Leather patch",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_leather_patch_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Nylon thread",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_nylon_thread_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Roll of thick leather",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_roll_leather_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Roll of fabric",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_roll_cloth_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Iron bracket",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_iron_bracket_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Copper bracket",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_copper_bracket_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Copper wire",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_copper_wire_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Copper case",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_copper_case_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Sapphire crystal",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_sapphire_glass_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Rivet",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_rivet_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Nut",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_nut_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Scrap metal",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_scrap_metal_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Rubber gasket",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_rubber_gasket_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Blade",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_blade_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Gear",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_gear_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Bearing",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_bearing_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Metal tube",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_metal_tube_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Flur shard",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_shard_flur_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Quark shard",
                ],
                'type'  => ItemTypeEnum::PART->value,
                'image' => 'resources/images/crafting_parts/cp_shard_quark_1.webp',
            ],

            [
                'name'  => [
                    'en' => "Recipe: Quantum Titanium Bolt",
                ],
                'type'  => ItemTypeEnum::RECIPE->value,
                'image' => 'resources/images/recipes/draft-bolt.png',
            ],
            [
                'name'  => [
                    'en' => "Recipe: Metal Plate",
                ],
                'type'  => ItemTypeEnum::RECIPE->value,
                'image' => 'resources/images/recipes/draft-metal_plate.png',
            ],
            [
                'name'  => [
                    'en' => "Recipe: Crystal Reflector",
                ],
                'type'  => ItemTypeEnum::RECIPE->value,
                'image' => 'resources/images/recipes/draft-crystal_reflector.png',
            ],
            [
                'name'  => [
                    'en' => "Recipe: Lamp With Dust",
                ],
                'type'  => ItemTypeEnum::RECIPE->value,
                'image' => 'resources/images/recipes/draft-lamp_dust.png',
            ],
            [
                'name'  => [
                    'en' => "Recipe: Heavy Jacket",
                ],
                'type'  => ItemTypeEnum::RECIPE->value,
                'image' => 'resources/images/recipes/draft-lamp_dust.png',
            ],
            [
                'name'  => [
                    'en' => "Recipe: Digger's Jumpsuit",
                ],
                'type'  => ItemTypeEnum::RECIPE->value,
                'image' => 'resources/images/recipes/draft-jumpsuit_digger_prof.png',
            ],
            [
                'name'  => [
                    'en' => "Recipe: Spyglass",
                ],
                'type'  => ItemTypeEnum::RECIPE->value,
                'image' => 'resources/images/recipes/draft-spyglass.png',
            ],
            [
                'name'  => [
                    'en' => "Recipe: Monocle",
                ],
                'type'  => ItemTypeEnum::RECIPE->value,
                'image' => 'resources/images/recipes/draft-monocle.png',
            ],
            [
                'name'  => [
                    'en' => "Recipe: Purity Serum",
                ],
                'type'  => ItemTypeEnum::RECIPE->value,
                'image' => 'resources/images/recipes/draft-serum_purity.png',
            ],
            [
                'name'  => [
                    'en' => "Recipe: Double-barreled Menton's Steam Rifle",
                ],
                'type'  => ItemTypeEnum::RECIPE->value,
                'image' => 'resources/images/recipes/draft-shotgun_steam_men.png',
            ],
            [
                'name'  => [
                    'en' => "Recipe: Large Healing Potion",
                ],
                'type'  => ItemTypeEnum::RECIPE->value,
                'image' => 'resources/images/recipes/draft-healing_big.png',
            ],
            [
                'name'  => [
                    'en' => "Recipe: Lamp With Dust",
                ],
                'type'  => ItemTypeEnum::RECIPE->value,
                'image' => 'resources/images/recipes/draft-lamp_dust.png',
            ],
            [
                'name'  => [
                    'en' => "Recipe: Rapier Of Retribution",
                ],
                'type'  => ItemTypeEnum::RECIPE->value,
                'image' => 'resources/images/recipes/draft-rapier_ret.png',
            ],
            [
                'name'  => [
                    'en' => "Recipe: Wristwatch",
                ],
                'type'  => ItemTypeEnum::RECIPE->value,
                'image' => 'resources/images/recipes/draft-wristwatch.png',
            ],
            [
                'name'  => [
                    'en' => "Recipe: Rivet",
                ],
                'type'  => ItemTypeEnum::RECIPE->value,
                'image' => 'resources/images/recipes/draft-rivet.png',
            ],
            [
                'name'  => [
                    'en' => "Recipe: Small Healing Potion",
                ],
                'type'  => ItemTypeEnum::RECIPE->value,
                'image' => 'resources/images/recipes/draft-healing_small.png',
            ],
            [
                'name'  => [
                    'en' => "Recipe: Steam Flashlight",
                ],
                'type'  => ItemTypeEnum::RECIPE->value,
                'image' => 'resources/images/recipes/draft-lantern_steam.png',
            ],


            [
                'name'  => [
                    'en' => "Iron",
                ],
                'type'  => ItemTypeEnum::RESOURCE->value,
                'image' => 'resources/images/resources/r_iron_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Copper",
                ],
                'type'  => ItemTypeEnum::RESOURCE->value,
                'image' => 'resources/images/resources/r_copper_1.webp',
            ],
            [
                'name'  => [
                    'en' => "Mica",
                ],
                'type'  => ItemTypeEnum::RESOURCE->value,
                'image' => 'resources/images/resources/r_mica_1.webp',
            ],
        ];

        foreach ($items as $item) {
            // Check if the item already exists
            if (\App\Models\Item::where('name->en', $item['name']['en'])->exists()) {
                continue; // Skip if the item already exists
            }
            $imagePath = base_path($item['image']);
            $dir = match ($item['type']) {
                ItemTypeEnum::EQUIPMENT->value => 'equipment',
                ItemTypeEnum::PART->value => 'parts',
                ItemTypeEnum::RECIPE->value => 'recipes',
                ItemTypeEnum::RESOURCE->value => 'resources',
                default => 'unknown',
            };
            $item['image'] = str_replace('resources/images/', '', $item['image']);
            $item['image'] = 'images/'.$dir.'/'.basename($item['image']);
            \App\Models\Item::create($item);
            if (file_exists($imagePath)) {
                \Storage::disk('public')->put($item['image'], file_get_contents($imagePath));
            } else {
                \Log::warning("Image not found: ".$imagePath);
            }
        }

    }
}
