<?php

declare(strict_types=1);

namespace App\Enum;

enum AdvancementEnum: string
{
    case CHOOSE_ANY_TABLE = "Choose a new skill in any table";
    case RANDON_STANDARD_TABLE = "Random skill in standard table";
    case ATTACKS  = "+ 1 attacks";
    case STRENGTH = "+ 1 strength";
    case BALLISTIC_WEAPON = "+ 1 BS";
    case WEAPON_SKILL = "+ 1 WS";
    case LEADERSHIP = "+ 1 leadership";
    case INITIATIVE = "+ 1 initiative";
    case TOUGHNESS = "+ 1 toughness";
    case WOUNDS = "+ 1 wounds";

    public function enumToString(): string
    {
        return match($this)
        {
            self::CHOOSE_ANY_TABLE => AdvancementEnum::CHOOSE_ANY_TABLE->value,
            self::RANDON_STANDARD_TABLE => AdvancementEnum::RANDON_STANDARD_TABLE->value,
            self::ATTACKS =>  AdvancementEnum::ATTACKS->value,
            self::STRENGTH => AdvancementEnum::STRENGTH->value,
            self::BALLISTIC_WEAPON =>  AdvancementEnum::BALLISTIC_WEAPON->value,
            self::WEAPON_SKILL =>  AdvancementEnum::WEAPON_SKILL->value,
            self::LEADERSHIP =>  AdvancementEnum::LEADERSHIP->value,
            self::INITIATIVE =>  AdvancementEnum::INITIATIVE->value,
            self::TOUGHNESS =>  AdvancementEnum::TOUGHNESS->value,
            self::WOUNDS =>  AdvancementEnum::WOUNDS->value,
        };
    }
}