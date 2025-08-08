<?php

namespace Database\Seeders;

use App\Enum\ItemRarityEnum;
use App\Enum\ItemTypeEnum;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name'   => [
                    'ru' => "Карманный Паромет 'Пшик-Х'",
                    'en' => 'Pocket Steamer Puff-x',
                ],
                'rarity' => ItemRarityEnum::UNCOMMON,
                'type'   => ItemTypeEnum::WEAPON->value,
                'image'  => 'resources/images/items/pocket_steam_gun_x_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "ККМ 'Ритти'",
                    'en' => 'Ritti Cash Machine',
                ],
                'rarity' => ItemRarityEnum::EPIC,
                'type'   => ItemTypeEnum::AMPILIER->value,
                'image'  => 'resources/images/items/cash_register_ritty_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Лампа с Дастом",
                    'en' => 'Lamp With Dust',
                ],
                'rarity' => ItemRarityEnum::RARE,
                'type'   => ItemTypeEnum::ACCESSORY->value,
                'image'  => 'resources/images/items/lamp_dust_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Плащ из золотой кожи",
                    'en' => 'Golden Leather Cloak',
                ],
                'rarity' => ItemRarityEnum::UNCOMMON,
                'type'   => ItemTypeEnum::BODY->value,
                'image'  => 'resources/images/items/cloak_golden_leather_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Медный рыцарский шлем",
                    'en' => 'Knight\'s Copper Helm',
                ],
                'rarity' => ItemRarityEnum::UNCOMMON,
                'type'   => ItemTypeEnum::HELMET->value,
                'image'  => 'resources/images/items/helmet_copper_missing_knight_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Комбинезон Диггера",
                    'en' => "Digger's Jumpsuit",
                ],
                'rarity' => ItemRarityEnum::RARE,
                'type'   => ItemTypeEnum::BODY->value,
                'image'  => 'resources/images/items/jumpsuit_digger_prof_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Сапоги Диггера",
                    'en' => "Digger's Boots",
                ],
                'rarity' => ItemRarityEnum::RARE,
                'type'   => ItemTypeEnum::BOOTS->value,
                'image'  => 'resources/images/items/boots_digger_leather_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Перчатки Диггера",
                    'en' => "Digger's Gloves",
                ],
                'rarity' => ItemRarityEnum::RARE,
                'type'   => ItemTypeEnum::GLOVES->value,
                'image'  => 'resources/images/items/gloves_digger_comfortable_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Противогаз  Диггера",
                    'en' => "Digger's Gas Mask",
                ],
                'rarity' => ItemRarityEnum::RARE,
                'type'   => ItemTypeEnum::HELMET->value,
                'image'  => 'resources/images/items/respirator_digger_homemade_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Кирка Рудокопа",
                    'en' => "Miner's Pickaxe",
                ],
                'rarity' => ItemRarityEnum::RARE,
                'type'   => ItemTypeEnum::WEAPON->value,
                'image'  => 'resources/images/items/pickaxe_lost_miner_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Сюртук Начальника Шахты",
                    'en' => "Mine Boss's Coat",
                ],
                'rarity' => ItemRarityEnum::RARE,
                'type'   => ItemTypeEnum::BODY->value,
                'image'  => 'resources/images/items/coat_mine_boss_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Каска Рудокопа",
                    'en' => "Miner's Helmet",
                ],
                'rarity' => ItemRarityEnum::RARE,
                'type'   => ItemTypeEnum::HELMET->value,
                'image'  => 'resources/images/items/hat_iron_underground_mod_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Перчатки любящего сердца",
                    'en' => "Gloves of a Loving Heart",
                ],
                'rarity' => ItemRarityEnum::LEGENDARY,
                'type'   => ItemTypeEnum::GLOVES->value,
                'image'  => 'resources/images/items/gloves_loving_heart_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Бриджи Начальника Шахты",
                    'en' => "Mine Boss's Breeches",
                ],
                'rarity' => ItemRarityEnum::RARE,
                'type'   => ItemTypeEnum::PANTS->value,
                'image'  => 'resources/images/items/breeches_mine_boss_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Ручная  Дрель",
                    'en' => "Hand Drill",
                ],
                'rarity' => ItemRarityEnum::RARE,
                'type'   => ItemTypeEnum::WEAPON->value,
                'image'  => 'resources/images/items/drill_lost_hand_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Колотушка “Чик - Чик”",
                    'en' => "Snip-snip Club",
                ],
                'rarity' => ItemRarityEnum::RARE,
                'type'   => ItemTypeEnum::WEAPON->value,
                'image'  => 'resources/images/items/mallet_cc_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Рапира Возмездия ",
                    'en' => "Rapier Of Retribution",
                ],
                'rarity' => ItemRarityEnum::EPIC,
                'type'   => ItemTypeEnum::WEAPON->value,
                'image'  => 'resources/images/items/rapier_ret_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Паровая Двустволка Ментона",
                    'en' => "Double-barreled Menton's Steam Rifle",
                ],
                'rarity' => ItemRarityEnum::EPIC,
                'type'   => ItemTypeEnum::WEAPON->value,
                'image'  => 'resources/images/items/shotgun_steam_men_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Медный Револьвер “Сэмюэль”",
                    'en' => 'Copper Revolver “samuel”',
                ],
                'rarity' => ItemRarityEnum::EPIC,
                'type'   => ItemTypeEnum::WEAPON->value,
                'image'  => 'resources/images/items/revolver_cooper_sam_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Бубен Духов Земли",
                    'en' => 'Earth Spirits Drum',
                ],
                'rarity' => ItemRarityEnum::EPIC,
                'type'   => ItemTypeEnum::WEAPON->value,
                'image'  => 'resources/images/items/drum_spirit_ert_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Вдоводел",
                    'en' => 'Widowmaker',
                ],
                'rarity' => ItemRarityEnum::EPIC,
                'type'   => ItemTypeEnum::WEAPON->value,
                'image'  => 'resources/images/items/widow_maker_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Кваркоруб",
                    'en' => 'Quark Cutter',
                ],
                'rarity' => ItemRarityEnum::LEGENDARY,
                'type'   => ItemTypeEnum::WEAPON->value,
                'image'  => 'resources/images/items/quark_cutter_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Флюровый Гладиус",
                    'en' => "Flur Gladius",
                ],
                'rarity' => ItemRarityEnum::LEGENDARY,
                'type'   => ItemTypeEnum::WEAPON->value,
                'image'  => 'resources/images/items/gladius_flur_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Камзол Барона Самеди",
                    'en' => "Baron Samedi's Coat",
                ],
                'rarity' => ItemRarityEnum::LEGENDARY,
                'type'   => ItemTypeEnum::BODY->value,
                'image'  => 'resources/images/items/camisole_baron_samedi_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Идеальный кристалл Флюра",
                    'en' => "Perfect flur crystal",
                ],
                'rarity' => ItemRarityEnum::EPIC,
                'type'   => ItemTypeEnum::ACCESSORY->value,
                'image'  => 'resources/images/items/crystal_perfectly_flure_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Ботинки Гринча",
                    'en' => "Grinch's boots",
                ],
                'rarity' => ItemRarityEnum::LEGENDARY,
                'type'   => ItemTypeEnum::BOOTS->value,
                'image'  => 'resources/images/items/boots_grinch_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Шлем Повелителя Тыкв",
                    'en' => "Pumpkin Lord Helmet",
                ],
                'rarity' => ItemRarityEnum::LEGENDARY,
                'type'   => ItemTypeEnum::HELMET->value,
                'image'  => 'resources/images/items/helmet_lord_pumpkins_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Штаны пасхального кролика",
                    'en' => "Easter bunny pants",
                ],
                'rarity' => ItemRarityEnum::LEGENDARY,
                'type'   => ItemTypeEnum::PANTS->value,
                'image'  => 'resources/images/items/pants_easter_bunny_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Посох “Душа Кварка”",
                    'en' => "Staff 'Soul of Quark'",
                ],
                'rarity' => ItemRarityEnum::EPIC,
                'type'   => ItemTypeEnum::WEAPON->value,
                'image'  => 'resources/images/items/staff_soul_qrk_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Перчатки со вставками",
                    'en' => "Gloves With Inserts",
                ],
                'rarity' => ItemRarityEnum::RARE,
                'type'   => ItemTypeEnum::GLOVES->value,
                'image'  => 'resources/images/items/gloves_copper_inserts_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Болтливый Огурецострел",
                    'en' => "Talkative Cucumber Shooter",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::WEAPON->value,
                'image'  => 'resources/images/items/shotgun_cucumber_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Топор железного дровосека",
                    'en' => "Tin Woodcutter's Axe",
                ],
                'rarity' => ItemRarityEnum::LEGENDARY,
                'type'   => ItemTypeEnum::WEAPON->value,
                'image'  => 'resources/images/items/axe_iron_woodman_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Тяжелая куртка",
                    'en' => "Heavy jacket",
                ],
                'rarity' => ItemRarityEnum::UNCOMMON,
                'type'   => ItemTypeEnum::BODY->value,
                'image'  => 'resources/images/items/jacket_heavy_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Паровой фонарик",
                    'en' => "Steam lantern",
                ],
                'rarity' => ItemRarityEnum::EPIC,
                'type'   => ItemTypeEnum::AMPILIER->value,
                'image'  => 'resources/images/items/lantern_steam_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "МОНОКЛЬ",
                    'en' => "Monocle",
                ],
                'rarity' => ItemRarityEnum::UNCOMMON,
                'type'   => ItemTypeEnum::HELMET->value,
                'image'  => 'resources/images/items/monocle_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Подзорная труба",
                    'en' => "Spyglass",
                ],
                'rarity' => ItemRarityEnum::RARE,
                'type'   => ItemTypeEnum::ACCESSORY->value,
                'image'  => 'resources/images/items/spyglass_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Наручные часы",
                    'en' => "Wristwatch",
                ],
                'rarity' => ItemRarityEnum::EPIC,
                'type'   => ItemTypeEnum::ACCESSORY->value,
                'image'  => 'resources/images/items/wristwatch_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Гидравлические ботинки",
                    'en' => "Hydraulic Boots",
                ],
                'rarity' => ItemRarityEnum::EPIC,
                'type'   => ItemTypeEnum::BOOTS->value,
                'image'  => 'resources/images/items/boots_hydraulic_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Медное колесо",
                    'en' => "Copper Wheel",
                ],
                'rarity' => ItemRarityEnum::EPIC,
                'type'   => ItemTypeEnum::ACCESSORY->value,
                'image'  => 'resources/images/items/wheel_copper_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Доспех червя",
                    'en' => "Worm's Armor",
                ],
                'rarity' => ItemRarityEnum::LEGENDARY,
                'type'   => ItemTypeEnum::BODY->value,
                'image'  => 'resources/images/items/armor_worm_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Глаз подземного ужаса",
                    'en' => "Eye of Terror",
                ],
                'rarity' => ItemRarityEnum::LEGENDARY,
                'type'   => ItemTypeEnum::AMPILIER->value,
                'image'  => 'resources/images/items/eye_horror_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Правосудие земных недр",
                    'en' => "Earth's Justice",
                ],
                'rarity' => ItemRarityEnum::LEGENDARY,
                'type'   => ItemTypeEnum::WEAPON->value,
                'image'  => 'resources/images/items/revolver_justice_ert_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Граната — Хлопушка",
                    'en' => "Grenade — Firecracker",
                ],
                'rarity' => ItemRarityEnum::LEGENDARY,
                'type'   => ItemTypeEnum::ACCESSORY->value,
                'image'  => 'resources/images/items/grenade_petard_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Граната — Зеленая полянка",
                    'en' => "Grenade — Green Meadow",
                ],
                'rarity' => ItemRarityEnum::EPIC,
                'type'   => ItemTypeEnum::AMPILIER->value,
                'image'  => 'resources/images/items/grenade_green_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Лоскуток ткани",
                    'en' => "Scrap cloth",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_scrap_cloth_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Кожаная заплатка",
                    'en' => "Leather patch",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_leather_patch_1.webp',
            ],
            [
                'name'   => [
                    'en' => "Nylon thread",
                    'ru' => "Нейлоновая нить",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_nylon_thread_1.webp',
            ],
            [
                'name'   => [
                    'en' => "Roll of thick leather",
                    'ru' => "Рулон толстой кожи",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_roll_leather_1.webp',
            ],
            [
                'name'   => [
                    'en' => "Roll of fabric",
                    'ru' => "Рулон плотной ткани",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_roll_cloth_1.webp',
            ],
            [
                'name'   => [
                    'en' => "Iron bracket",
                    'ru' => "Железная скоба",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_iron_bracket_1.webp',
            ],
            [
                'name'   => [
                    'en' => "Copper bracket",
                    'ru' => "Медная скоба",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_copper_bracket_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Медная проволока",
                    'en' => "Copper wire",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_copper_wire_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Медный футляр",
                    'en' => "Copper case",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_copper_case_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Сапфировое стекло",
                    'en' => "Sapphire crystal",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_sapphire_glass_1.webp',
            ],
            [
                'name'   => [
                    'en' => "Rivet",
                    'ru' => "Заклепка",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_rivet_1.webp',
            ],
            [
                'name'   => [
                    'en' => "Nut",
                    'ru' => "Гайка",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_nut_1.webp',
            ],
            [
                'name'   => [
                    'en' => "Scrap metal",
                    'ru' => "Металлолом",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_scrap_metal_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Резиновая прокладка",
                    'en' => "Rubber gasket",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_rubber_gasket_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Лезвие",
                    'en' => "Blade",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_blade_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Шестеренка",
                    'en' => "Gear",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_gear_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Подшипник",
                    'en' => "Bearing",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_bearing_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Металлическая трубка",
                    'en' => "Metal tube",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_metal_tube_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Осколки флюра",
                    'en' => "Flur shard",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_shard_flur_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Осколки кварка",
                    'en' => "Quark shard",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/cp_shard_quark_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "КРИСТАЛЛИЧЕСКИЙ ОТРАЖАТЕЛЬ",
                    'en' => "Crystal Reflector",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/crystal_reflector_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Кванто-титановый болт",
                    'en' => "Quantum Titanium Bolt",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/bolt_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Металлическая пластина",
                    'en' => "Metal Plate",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::PART->value,
                'image'  => 'resources/images/crafting_parts/metal_plate_1.webp',
            ],

            [
                'name'   => [
                    'ru' => "Сыворотка чистоты",
                    'en' => "Purity Serum",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::CONSUMABLE->value,
                'image'  => 'resources/images/consumable/serum_purity_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "БОЛЬШОЕ ЗЕЛЬЕ ЛЕЧЕНИЯ",
                    'en' => "Large Healing Potion",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::CONSUMABLE->value,
                'image'  => 'resources/images/consumable/healing_big_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "МАЛОЕ ЗЕЛЬЕ ЛЕЧЕНИЯ",
                    'en' => "Small Healing Potion",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::CONSUMABLE->value,
                'image'  => 'resources/images/consumable/healing_small_1.webp',
            ],

            [
                'name'   => [
                    'ru' => "РЕЦЕПТ: КВАНТО-ТИТАНОВЫЙ БОЛТ",
                    'en' => "Recipe: Quantum Titanium Bolt",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-bolt.png',
            ],
            [
                'name'   => [
                    'ru' => "Рецепт: Металлическая пластина",
                    'en' => "Recipe: Metal Plate",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-metal_plate.png',
            ],
            [
                'name'   => [
                    'ru' => "РЕЦЕПТ: КРИСТАЛЛИЧЕСКИЙ ОТРАЖАТЕЛЬ",
                    'en' => "Recipe: Crystal Reflector",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-crystal_reflector.png',
            ],
            [
                'name'   => [
                    'ru' => "РЕЦЕПТ: ЛАМПА С ДАСТОМ",
                    'en' => "Recipe: Lamp With Dust",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-lamp_dust.png',
            ],
            [
                'name'   => [
                    'ru' => "РЕЦЕПТ: ТЯЖЕЛАЯ КУРТКА",
                    'en' => "Recipe: Heavy Jacket",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-lamp_dust.png',
            ],
            [
                'name'   => [
                    'ru' => "РЕЦЕПТ: КОМБИНЕЗОН ДИГГЕРА",
                    'en' => "Recipe: Digger's Jumpsuit",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-jumpsuit_digger_prof.png',
            ],
            [
                'name'   => [
                    'ru' => "РЕЦЕПТ: ПОДЗОРНАЯ ТРУБА",
                    'en' => "Recipe: Spyglass",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-spyglass.png',
            ],
            [
                'name'   => [
                    'ru' => "РЕЦЕПТ: МОНОКЛЬ",
                    'en' => "Recipe: Monocle",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-monocle.png',
            ],
            [
                'name'   => [
                    'ru' => "РЕЦЕПТ: СЫВОРОТКА ЧИСТОТЫ",
                    'en' => "Recipe: Purity Serum",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-serum_purity.png',
            ],
            [
                'name'   => [
                    'ru' => "РЕЦЕПТ: ПАРОВАЯ ДВУСТВОЛКА МЕНТОНА",
                    'en' => "Recipe: Double-barreled Menton's Steam Rifle",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-shotgun_steam_men.png',
            ],
            [
                'name'   => [
                    'ru' => "РЕЦЕПТ: БОЛЬШОЕ ЗЕЛЬЕ ЛЕЧЕНИЯ",
                    'en' => "Recipe: Large Healing Potion",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-healing_big.png',
            ],
            [
                'name'   => [
                    'ru' => "РЕЦЕПТ: РАПИРА ВОЗМЕЗДИЯ",
                    'en' => "Recipe: Rapier Of Retribution",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-rapier_ret.png',
            ],
            [
                'name'   => [
                    'ru' => "РЕЦЕПТ: НАРУЧНЫЕ ЧАСЫ",
                    'en' => "Recipe: Wristwatch",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-wristwatch.png',
            ],
            [
                'name'   => [
                    'ru' => "РЕЦЕПТ: Заклепка",
                    'en' => "Recipe: Rivet",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-rivet.png',
            ],
            [
                'name'   => [
                    'ru' => "РЕЦЕПТ: МАЛОЕ ЗЕЛЬЕ ЛЕЧЕНИЯ",
                    'en' => "Recipe: Small Healing Potion",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-healing_small.png',
            ],
            [
                'name'   => [
                    'ru' => "РЕЦЕПТ: ПАРОВОЙ ФОНАРИК",
                    'en' => "Recipe: Steam Flashlight",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-lantern_steam.png',
            ],
            [
                'name'   => [
                    'ru' => "РЕЦЕПТ: Металлическая трубка",
                    'en' => "Recipe: Metal TUbe",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-metal_tube.png',
            ],
            [
                'name'   => [
                    'ru' => "РЕЦЕПТ: ПОСОХ “ДУША КВАРКА”",
                    'en' => "Recipe: Staff 'Soul of Quark'",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RECIPE->value,
                'image'  => 'resources/images/recipes/draft-staff_soul_qrk.png',
            ],

            [
                'name'   => [
                    'ru' => "Железо",
                    'en' => "Iron",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RESOURCE->value,
                'image'  => 'resources/images/resources/r_iron_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Медь",
                    'en' => "Copper",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RESOURCE->value,
                'image'  => 'resources/images/resources/r_copper_1.webp',
            ],
            [
                'name'   => [
                    'ru' => "Слюда",
                    'en' => "Mica",
                ],
                'rarity' => ItemRarityEnum::COMMON,
                'type'   => ItemTypeEnum::RESOURCE->value,
                'image'  => 'resources/images/resources/r_mica_1.webp',
            ],
        ];

        foreach ($items as $item) {
            $existingItem = \App\Models\Item::query()
                ->where('name->en', $item['name']['en'])
                ->first();
            if ($existingItem) {
                $existingItem->name = $item['name'];
                $existingItem->type = $item['type'];
                $existingItem->rarity = $item['rarity'];
                $existingItem->save();
                continue;
            }
            $imagePath = base_path($item['image']);
            $dir = match ($item['type']) {
                ItemTypeEnum::WEAPON->value => 'weapons',
                ItemTypeEnum::PANTS->value => 'pants',
                ItemTypeEnum::GLOVES->value => 'gloves',
                ItemTypeEnum::BODY->value => 'bodies',
                ItemTypeEnum::HELMET->value => 'helmets',
                ItemTypeEnum::BOOTS->value => 'boots',
                ItemTypeEnum::AMPILIER->value => 'amplifiers',
                ItemTypeEnum::ACCESSORY->value => 'accessories',
                ItemTypeEnum::CONSUMABLE->value => 'consumables',
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
