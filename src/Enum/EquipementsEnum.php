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

    public function getDescription(): string
    {
        return match($this)
        {
            self::ClipHarness => 'Prevents falls when climbing. Roll a D6 if you would fall; on a 4+, you stay in place',
            self::FilterPlugs => 'Grants immunity to gas weapons and toxic effects',
            self::LoboChip => 'Grants immunity to psychology but reduces Initiative by 1',
            self::PhotoContacts => 'The user is immune to the effects of flash grenades and gains +1 to hit in low-light conditions',
            self::WeaponReload => 'Once per game, reroll a failed Ammo Roll',
        };
    }
}
