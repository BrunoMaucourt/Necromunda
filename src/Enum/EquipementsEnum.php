<?php

declare(strict_types=1);

namespace App\Enum;

use App\Contract\ItemEnumInterface;

enum EquipementsEnum: string implements ItemEnumInterface

{
    const ARMORS = 'Armors';
    const WEAPON_EQUIPEMENT = 'Weapon equipment';
    const PERSONAL_EQUIPMENT = 'Personal equipment';
    const BIONICS = 'Bionics';
    const GANG_EQUIPEMENT = 'Gang Equipment';

    // ARMORS
    case ArmourFlak = 'Armour - Flak';
    case ArmourMesh = 'Armour - Mesh';
    case ExoticArmourCarapace = 'Exotic Armour - Carapace';
    case ExoticArmourForceField = 'Exotic Armour - Force Field';

    // BIONICS
    case BerserkerChip = 'Berserker Chip';
    case BionicArm = 'Bionic Arm';
    case BionicImplant = 'Bionic Implant';
    case BionicLeg = 'Bionic Leg';
    case BionicEye = 'Bionic Eye';
    case BionicChest = 'Bionic Chest';
    case LoboChip = 'Lobo-chip';
    case SkullChip = 'Skull Chip';

    // GANG_EQUIPEMENT
    case HeavyGearAutoRepairer = 'Heavy Gear - Auto-repairer';
    case IsotropicFuelRod = 'Isotropic Fuel Rod';
    case MungVase = 'Mung Vase';
    case RaidGearScreamersOrStummers = 'Raid Gear - Screamers or Stummers';
    case RatskinMap = 'Ratskin Map';

    // PERSONAL_EQUIPMENT
    case BioBooster = 'Bio-booster';
    case BioScanner = 'Bio-scanner';
    case BlindSnakePouch = 'Blindsnake Pouch';
    case ClipHarness = 'Clip Harness';
    case ConcealedBlade = 'Concealed Blade';
    case FilterPlugs = 'Filter Plugs';
    case GravChute = 'Grav Chute';
    case Grapnel = 'Grapnel';
    case InfraRedGoggles = 'Infra-red Goggles';
    case MediPack = 'Medi-pack';
    case PhotoContacts = 'Photo-contacts';
    case PhotoVisor = 'Photo-visor';
    case Respirator = 'Respirator';
    case StingerPouch = 'Stinger Pouch';

    // WEAPON_EQUIPEMENT
    case DrumMagazine = 'Drum magazine';
    case GunsightInfraRedSight = 'Gunsight - Infra-red Sight';
    case GunsightMonoSight = 'Gunsight - Mono-sight';
    case GunsightRedDotLaser = 'Gunsight - Red-dot Laser';
    case GunsightTelescopicSight = 'Gunsight - Telescopic Sight';
    case HeavyGearSuspensor = 'Heavy Gear - Suspensor';
    case RaidGearSilencer = 'Raid Gear - Silencer';
    case RareWeaponOneInAMillionWeapon = 'Rare Weapon - One in a Million Weapon';
    case WeaponReload = 'Weapon Reload';

    public function enumToString(): string
    {
        return match($this)
        {
            // ARMORS
            self::ArmourFlak => EquipementsEnum::ArmourFlak->value,
            self::ArmourMesh => EquipementsEnum::ArmourMesh->value,
            self::ExoticArmourCarapace => EquipementsEnum::ExoticArmourCarapace->value,
            self::ExoticArmourForceField => EquipementsEnum::ExoticArmourForceField->value,

            // BIONICS
            self::BerserkerChip => EquipementsEnum::BerserkerChip->value,
            self::BionicArm => EquipementsEnum::BionicArm->value,
            self::BionicImplant => EquipementsEnum::BionicImplant->value,
            self::BionicLeg => EquipementsEnum::BionicLeg->value,
            self::BionicEye => EquipementsEnum::BionicEye->value,
            self::BionicChest => EquipementsEnum::BionicChest->value,
            self::LoboChip => EquipementsEnum::LoboChip->value,
            self::SkullChip => EquipementsEnum::SkullChip->value,

            // GANG_EQUIPEMENT
            self::HeavyGearAutoRepairer => EquipementsEnum::HeavyGearAutoRepairer->value,
            self::IsotropicFuelRod => EquipementsEnum::IsotropicFuelRod->value,
            self::MungVase => EquipementsEnum::MungVase->value,
            self::RaidGearScreamersOrStummers => EquipementsEnum::RaidGearScreamersOrStummers->value,
            self::RatskinMap => EquipementsEnum::RatskinMap->value,

            // PERSONAL_EQUIPMENT
            self::BioBooster => EquipementsEnum::BioBooster->value,
            self::BioScanner => EquipementsEnum::BioScanner->value,
            self::BlindSnakePouch => EquipementsEnum::BlindSnakePouch->value,
            self::ClipHarness => EquipementsEnum::ClipHarness->value,
            self::ConcealedBlade => EquipementsEnum::ConcealedBlade->value,
            self::FilterPlugs => EquipementsEnum::FilterPlugs->value,
            self::GravChute => EquipementsEnum::GravChute->value,
            self::Grapnel => EquipementsEnum::Grapnel->value,
            self::InfraRedGoggles => EquipementsEnum::InfraRedGoggles->value,
            self::MediPack => EquipementsEnum::MediPack->value,
            self::PhotoContacts => EquipementsEnum::PhotoContacts->value,
            self::PhotoVisor => EquipementsEnum::PhotoVisor->value,
            self::Respirator => EquipementsEnum::Respirator->value,
            self::StingerPouch => EquipementsEnum::StingerPouch->value,

            // WEAPON_EQUIPEMENT
            self::DrumMagazine => EquipementsEnum::DrumMagazine->value,
            self::GunsightInfraRedSight => EquipementsEnum::GunsightInfraRedSight->value,
            self::GunsightMonoSight => EquipementsEnum::GunsightMonoSight->value,
            self::GunsightRedDotLaser => EquipementsEnum::GunsightRedDotLaser->value,
            self::GunsightTelescopicSight => EquipementsEnum::GunsightTelescopicSight->value,
            self::HeavyGearSuspensor => EquipementsEnum::HeavyGearSuspensor->value,
            self::RaidGearSilencer => EquipementsEnum::RaidGearSilencer->value,
            self::RareWeaponOneInAMillionWeapon => EquipementsEnum::RareWeaponOneInAMillionWeapon->value,
            self::WeaponReload => EquipementsEnum::WeaponReload->value,
        };
    }

    public function getFixedCost(): int
    {
        return match($this)
        {
            // ARMORS
            self::ArmourFlak => 10,
            self::ArmourMesh => 25,
            self::ExoticArmourCarapace => 60,
            self::ExoticArmourForceField => 100,

            // BIONICS
            self::BerserkerChip => 25,
            self::BionicArm => 80,
            self::BionicImplant => 50,
            self::BionicLeg => 80,
            self::BionicEye => 50,
            self::BionicChest => 50,
            self::LoboChip => 20,
            self::SkullChip => 30,

            // GANG_EQUIPEMENT
            self::HeavyGearAutoRepairer => 80,
            self::IsotropicFuelRod => 50,
            self::MungVase => 0,
            self::RaidGearScreamersOrStummers => 10,
            self::RatskinMap => 0,

            // PERSONAL_EQUIPMENT
            self::BioBooster => 40,
            self::BioScanner => 50,
            self::BlindSnakePouch => 30,
            self::ClipHarness => 10,
            self::ConcealedBlade => 10,
            self::FilterPlugs => 10,
            self::GravChute => 40,
            self::Grapnel => 30,
            self::InfraRedGoggles => 30,
            self::MediPack => 80,
            self::PhotoContacts => 15,
            self::PhotoVisor => 25,
            self::Respirator => 15,
            self::StingerPouch => 10,

            // WEAPON_EQUIPEMENT
            self::DrumMagazine => 15,
            self::GunsightInfraRedSight => 30,
            self::GunsightMonoSight => 40,
            self::GunsightRedDotLaser => 40,
            self::GunsightTelescopicSight => 20,
            self::HeavyGearSuspensor => 50,
            self::RaidGearSilencer => 10,
            self::RareWeaponOneInAMillionWeapon => 0,
            self::WeaponReload => 0,
        };
    }

    public function getVariableDicesNumber(): int
    {
        return match($this)
        {
            // ARMORS
            self::ArmourFlak => 2,
            self::ArmourMesh => 2,
            self::ExoticArmourCarapace => 3,
            self::ExoticArmourForceField => 4,

            // BIONICS
            self::BerserkerChip => 3,
            self::BionicArm => 3,
            self::BionicImplant => 3,
            self::BionicLeg => 3,
            self::BionicEye => 3,
            self::BionicChest => 3,
            self::LoboChip => 0,
            self::SkullChip => 3,

            // GANG_EQUIPEMENT
            self::HeavyGearAutoRepairer => 4,
            self::IsotropicFuelRod => 4,
            self::MungVase => 1,
            self::RaidGearScreamersOrStummers => 3,
            self::RatskinMap => 1,

            // PERSONAL_EQUIPMENT
            self::BioBooster => 4,
            self::BioScanner => 3,
            self::BlindSnakePouch => 2,
            self::ClipHarness => 0,
            self::ConcealedBlade => 1,
            self::FilterPlugs => 0,
            self::GravChute => 4,
            self::Grapnel => 4,
            self::InfraRedGoggles => 3,
            self::MediPack => 4,
            self::PhotoContacts => 0,
            self::PhotoVisor => 2,
            self::Respirator => 2,
            self::StingerPouch => 3,

            // WEAPON_EQUIPEMENT
            self::DrumMagazine => 2,
            self::GunsightInfraRedSight => 3,
            self::GunsightMonoSight => 3,
            self::GunsightRedDotLaser => 3,
            self::GunsightTelescopicSight => 3,
            self::HeavyGearSuspensor => 3,
            self::RaidGearSilencer => 2,
            self::RareWeaponOneInAMillionWeapon => 0,
            self::WeaponReload => 0,
        };
    }

    public function getVariableDicesType(): int
    {
        return match($this)
        {
            // ARMORS
            self::ArmourFlak => 6,
            self::ArmourMesh => 6,
            self::ExoticArmourCarapace => 6,
            self::ExoticArmourForceField => 6,

            // BIONICS
            self::BerserkerChip => 6,
            self::BionicArm => 6,
            self::BionicImplant => 6,
            self::BionicLeg => 6,
            self::BionicEye => 6,
            self::BionicChest => 6,
            self::LoboChip => 0,
            self::SkullChip => 6,

            // GANG_EQUIPEMENT
            self::HeavyGearAutoRepairer => 6,
            self::IsotropicFuelRod => 6,
            self::MungVase => 10,
            self::RaidGearScreamersOrStummers => 6,
            self::RatskinMap => 10,

            // PERSONAL_EQUIPMENT
            self::BioBooster => 6,
            self::BioScanner => 6,
            self::BlindSnakePouch => 6,
            self::ClipHarness => 0,
            self::ConcealedBlade => 6,
            self::FilterPlugs => 0,
            self::GravChute => 6,
            self::Grapnel => 6,
            self::InfraRedGoggles => 6,
            self::MediPack => 6,
            self::PhotoContacts => 0,
            self::PhotoVisor => 6,
            self::Respirator => 6,
            self::StingerPouch => 6,

            // WEAPON_EQUIPEMENT
            self::DrumMagazine => 6,
            self::GunsightInfraRedSight => 6,
            self::GunsightMonoSight => 6,
            self::GunsightRedDotLaser => 6,
            self::GunsightTelescopicSight => 6,
            self::HeavyGearSuspensor => 6,
            self::RaidGearSilencer => 6,
            self::RareWeaponOneInAMillionWeapon => 0,
            self::WeaponReload => 0,
        };
    }

    public function getDescription(): string
    {
        return match($this)
        {
            // ARMORS
            self::ArmourFlak => 'Grants a 6+ armor save against wounds. The armor save improves to 5+ against wounds inflicted by template weapons.',
            self::ArmourMesh => 'Grants a 5+ armor save against wounds.',
            self::ExoticArmourCarapace => 'Grants a 4+ armor save against wounds, but the model suffers a -1 penalty to its Initiative (I) tests.',
            self::ExoticArmourForceField => 'Applies a -1 penalty to Strength (S) and to the armor save modifier of ranged weapons.',

            // BIONICS
            self::BerserkerChip => 'Once per game, the model can activate the chip to gain a +2 bonus to its Movement (M) and Strength (S) characteristics and go into Frenzy until the start of its next turn. At the end of the activation, its Initiative (I) is reduced to 1 for the rest of the battle.',
            self::BionicArm => 'The model gains a +2 bonus to its Strength (S) characteristic and a +2 bonus to Initiative (I) when testing if it falls from an edge.',
            self::BionicImplant => 'The implant allows the model to heal all Serious Injuries related to a single limb.',
            self::BionicLeg => 'The model gains a +1 bonus to its Movement (M) and Attacks (A) characteristics.',
            self::BionicEye => 'The model can never be blinded or dazzled. Its vision in the dark is enhanced. The model can visually detect hidden opponents at three times the normal range and is immune to smoke grenades. The model detects opponents in cover as if they were in the open.',
            self::BionicChest => 'The model is immune to the effects of gas. Grants a 6+ Armor Save.',
            self::LoboChip => 'Grants immunity to psychology but reduces Initiative by 1',
            self::SkullChip => 'The model can re-roll all its Initiative (I) checks. If the second roll fails, the chip can no longer be used for the rest of the battle.',

            // GANG_EQUIPEMENT
            self::HeavyGearAutoRepairer => 'A ganger and a heavy who have not gone Out of Action can use the auto-repairer instead of collecting income. All weapons ignore their missed ammo and blast rolls on a result of 4+. The auto-repairer is associated with a specific territory and can be disrupted, damaged, or lost along with it. Additionally, its value is added to the Gang Rating.',
            self::IsotropicFuelRod => 'Can transform any territory into a settlement.',
            self::MungVase => 'The price of the Mung Vase can only be determined once a gang has decided to purchase it. Once bought, it is kept in a location known only to the Leader (the Mung Vase is lost if the Leader dies). A ganger can sell the vase instead of collecting income. The sale can be refused. Roll a D6: ▪ 1: The vase is sold for D6 credits. The sale cannot be refused. ▪ 2: You are offered 2D6 credits. ▪ 5: You are offered 2D6x10 credits. ▪ 3-4: You are offered 30 + 6D6 credits. ▪ 6: You are offered 3D6x10 credits.',
            self::RaidGearScreamersOrStummers => 'Blockers can only be deployed in a single scenario before being removed. Roll a D6 for each attacker that has moved. On a result of 6, the alarm is triggered.',
            self::RatskinMap => 'To use the card, it must be carried by the gang leader. Its value is added to the model. Roll a D6: ▪ 1: The opponent chooses the scenario. ▪ 2: Roll a D6, on a result of 6, the Archeotech Hoard territory is added to the gang, and the card is removed. ▪ 3: The player can modify the result by +/-1 to choose the next scenario. ▪ 4: The player can modify the result by +/-2 to choose the next scenario. ▪ 5: Same as 4, but a Vents or Tunnels territory can be added to the gang. ▪ 6: The player can modify the result by +/-3 to choose the next scenario. If the card is used to modify a scenario, roll a D6. If the result is less than or equal to the modifier, the maximum modifier is reduced by 1. If the maximum modifier is reduced to 0, the card is removed.',

            // PERSONAL_EQUIPMENT
            self::BioBooster => 'The model treats results of 1-4 as a Flesh Wound during its first recovery phase. One use per battle.',
            self::BioScanner => 'Instead of shooting, the model can detect all hidden models within 16\'\' The model detects an opponent within 16\'\' and sounds the alarm at the end of its turn on a 4+.',
            self::BlindSnakePouch => 'Grants a 4+ invulnerable save against overwatch shots (Sentinel).',
            self::ClipHarness => 'Prevents falls when climbing. Roll a D6 if you would fall; on a 4+, you stay in place',
            self::ConcealedBlade => 'The model may roll a D6 if it is captured: ▪ 1: The model is killed, and its equipment is kept by its captors. ▪ 2: The model is immediately recaptured. ▪ 3: The model escapes, but its equipment is kept by its captors. ▪ 4-6: The model successfully escapes with all its equipment.',
            self::FilterPlugs => 'The model can re-roll its Toughness (T) tests to resist the effects of gas.',
            self::GravChute => 'The model is no longer limited to a 3\'\' fall and no longer suffers fall damage.',
            self::Grapnel => 'The model can attach itself during its movement phase by remaining stationary. It automatically passes Initiative checks to avoid falling when pinned within 1\'\' of an edge.',
            self::InfraRedGoggles => 'The model can visually detect hidden opponents at three times the normal range and is immune to smoke grenades. Its vision in the dark is enhanced. The model detects opponents in cover as if they were in the open.',
            self::MediPack => 'If the model is in contact with a fallen ally, that ally will treat results of 1-4 as a Flesh Wound during their recovery phase. The model cannot use the medipack on itself.',
            self::PhotoContacts => 'The user is immune to the effects of flash grenades and gains +1 to hit in low-light conditions',
            self::PhotoVisor => 'The model can never be blinded or dazzled. Its vision in the dark is enhanced.',
            self::Respirator => 'The model is immune to the effects of gas.',
            self::StingerPouch => 'If the model goes Out of Action at the end of a battle, on a 4+, it may avoid suffering a serious injury. Heals a Grievous Wound on a 4+. The med-pouch can only be used once before being removed.',

            // WEAPON_EQUIPEMENT
            self::DrumMagazine => 'Autopistols, autoguns, and autosluggers can be fitted with a drum magazine, granting a +1 to hit but always requiring an Ammo roll when used.',
            self::GunsightInfraRedSight => 'This sight can be equipped on basic weapons. A stationary shooter reduces the target\'s cover bonus by -1 and is immune to smoke grenades. The shooter\'s vision in the dark is enhanced.',
            self::GunsightMonoSight => 'This sight can be equipped on basic weapons, special weapons, or heavy weapons. A stationary shooter gains a +1 bonus to hit.',
            self::GunsightRedDotLaser => 'The laser sight can be equipped on pistols, basic weapons, or special weapons. The shooter gains a +1 bonus to hit, but the target gains a 6+ invulnerable save if it can see the shooter.',
            self::GunsightTelescopicSight => 'This sight can be equipped on basic weapons. The weapon\'s short range is added to its long range.',
            self::HeavyGearSuspensor => 'Blockers can only be deployed in a single scenario before being removed. They reduce the chances of triggering the alarm in certain scenarios by lowering the D6 roll by 1. Blockers completely nullify screamers.',
            self::RaidGearSilencer => 'The silencer can be equipped on a revolver, autopistol, submachine gun, shotgun, or light machine gun. The weapon cannot trigger the alarm.',
            self::RareWeaponOneInAMillionWeapon => 'Roll a D6 to determine the type of weapon: pistol (1-2), basic weapon (3-4), special weapon (5), or heavy weapon (6). The player then chooses a weapon of their choice within the category, which costs double its price and automatically passes all its ammo rolls.',
            self::WeaponReload => 'Once per game, reroll a failed Ammo Roll',
        };
    }

    public function isCustomRules(): bool
    {
        return match($this)
        {
            // ARMORS
            self::ArmourFlak => false,
            self::ArmourMesh => false,
            self::ExoticArmourCarapace => false,
            self::ExoticArmourForceField => false,

            // BIONICS
            self::BerserkerChip => false,
            self::BionicArm => false,
            self::BionicImplant => false,
            self::BionicLeg => false,
            self::BionicEye => false,
            self::BionicChest => false,
            self::LoboChip => false,
            self::SkullChip => false,

            // GANG_EQUIPEMENT
            self::HeavyGearAutoRepairer => false,
            self::IsotropicFuelRod => false,
            self::MungVase => false,
            self::RaidGearScreamersOrStummers => false,
            self::RatskinMap => false,

            // PERSONAL_EQUIPMENT
            self::BioBooster => false,
            self::BioScanner => false,
            self::BlindSnakePouch => false,
            self::ClipHarness => false,
            self::ConcealedBlade => false,
            self::FilterPlugs => false,
            self::GravChute => false,
            self::Grapnel => false,
            self::InfraRedGoggles => false,
            self::MediPack => false,
            self::PhotoContacts => false,
            self::PhotoVisor => false,
            self::Respirator => false,
            self::StingerPouch => false,

            // WEAPON_EQUIPEMENT
            self::DrumMagazine => false,
            self::GunsightInfraRedSight => false,
            self::GunsightMonoSight => false,
            self::GunsightRedDotLaser => false,
            self::GunsightTelescopicSight => false,
            self::HeavyGearSuspensor => false,
            self::RaidGearSilencer => false,
            self::RareWeaponOneInAMillionWeapon => false,
            self::WeaponReload => false,
        };
    }

    public function getType(): string
    {
        return match($this)
        {
            // ARMORS
            self::ArmourFlak => self::ARMORS,
            self::ArmourMesh => self::ARMORS,
            self::ExoticArmourCarapace => self::ARMORS,
            self::ExoticArmourForceField => self::ARMORS,

            // BIONICS
            self::BerserkerChip => self::BIONICS,
            self::BionicArm => self::BIONICS,
            self::BionicImplant => self::BIONICS,
            self::BionicLeg => self::BIONICS,
            self::BionicEye => self::BIONICS,
            self::BionicChest => self::BIONICS,
            self::LoboChip => self::BIONICS,
            self::SkullChip => self::BIONICS,

            // GANG_EQUIPEMENT
            self::HeavyGearAutoRepairer => self::GANG_EQUIPEMENT,
            self::IsotropicFuelRod => self::GANG_EQUIPEMENT,
            self::MungVase => self::GANG_EQUIPEMENT,
            self::RaidGearScreamersOrStummers => self::GANG_EQUIPEMENT,
            self::RatskinMap => self::GANG_EQUIPEMENT,

            // PERSONAL_EQUIPMENT
            self::BioBooster => self::PERSONAL_EQUIPMENT,
            self::BioScanner => self::PERSONAL_EQUIPMENT,
            self::BlindSnakePouch => self::PERSONAL_EQUIPMENT,
            self::ClipHarness => self::PERSONAL_EQUIPMENT,
            self::ConcealedBlade => self::PERSONAL_EQUIPMENT,
            self::FilterPlugs => self::PERSONAL_EQUIPMENT,
            self::GravChute => self::PERSONAL_EQUIPMENT,
            self::Grapnel => self::PERSONAL_EQUIPMENT,
            self::InfraRedGoggles => self::PERSONAL_EQUIPMENT,
            self::MediPack => self::PERSONAL_EQUIPMENT,
            self::PhotoContacts => self::PERSONAL_EQUIPMENT,
            self::PhotoVisor => self::PERSONAL_EQUIPMENT,
            self::Respirator => self::PERSONAL_EQUIPMENT,
            self::StingerPouch => self::PERSONAL_EQUIPMENT,

            // WEAPON_EQUIPEMENT
            self::DrumMagazine => self::WEAPON_EQUIPEMENT,
            self::GunsightInfraRedSight => self::WEAPON_EQUIPEMENT,
            self::GunsightMonoSight => self::WEAPON_EQUIPEMENT,
            self::GunsightRedDotLaser => self::WEAPON_EQUIPEMENT,
            self::GunsightTelescopicSight => self::WEAPON_EQUIPEMENT,
            self::HeavyGearSuspensor => self::WEAPON_EQUIPEMENT,
            self::RaidGearSilencer => self::WEAPON_EQUIPEMENT,
            self::RareWeaponOneInAMillionWeapon => self::WEAPON_EQUIPEMENT,
            self::WeaponReload => self::WEAPON_EQUIPEMENT,
        };
    }
}