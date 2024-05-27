<?php

declare(strict_types=1);

namespace App\Enum;

enum EquipementsEnum: string
{
    case ClipHarness = 'Clip Harness';
    case FilterPlugs = 'Filter Plugs';
    case LoboChip = 'Lobo-chip';
    case PhotoContacts = 'Photo-contacts';
    case WeaponReload = 'Weapon Reload';

    public function enumToString(): string
    {
        return match($this)
        {
            self::ClipHarness => EquipementsEnum::ClipHarness->value,
            self::FilterPlugs => EquipementsEnum::FilterPlugs->value,
            self::LoboChip => EquipementsEnum::LoboChip->value,
            self::PhotoContacts => EquipementsEnum::PhotoContacts->value,
            self::WeaponReload => EquipementsEnum::WeaponReload->value,
        };
    }

    public function getFixedCost(): int
    {
        return match($this)
        {
            self::ClipHarness => 10,
            self::FilterPlugs => 10,
            self::LoboChip => 20,
            self::PhotoContacts => 15,
            self::WeaponReload => 0,
        };
    }
}