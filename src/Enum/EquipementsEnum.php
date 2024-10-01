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
    case ArmourFlak = 'Armour - Flak';
    case ArmourMesh = 'Armour - Mesh';
    case BerserkerChip = 'Berserker Chip';
    case BioBooster = 'Bio-booster';
    case BioScanner = 'Bio-scanner';
    case BlindSnakePouch = 'Blindsnake Pouch';
    case BionicArm = 'Bionic Arm';
    case BionicImplant = 'Bionic Implant';
    case BionicLeg = 'Bionic Leg';
    case BionicEye = 'Bionic Eye';
    case BionicTorso = 'Bionic Torso';
    case ClipHarness = 'Clip Harness';
    case ConcealedBlade = 'Concealed Blade';
    case ExoticArmourCarapace = 'Exotic Armour - Carapace';
    case ExoticArmourForceField = 'Exotic Armour - Force Field';
    case FilterPlugs = 'Filter Plugs';
    case GravChute = 'Grav Chute';
    case Grapnel = 'Grapnel';
    case GunsightInfraRedSight = 'Gunsight - Infra-red Sight';
    case GunsightMonoSight = 'Gunsight - Mono-sight';
    case GunsightRedDotLaser = 'Gunsight - Red-dot Laser';
    case GunsightTelescopicSight = 'Gunsight - Telescopic Sight';
    case HeavyGearAutoRepairer = 'Heavy Gear - Auto-repairer';
    case HeavyGearSuspensor = 'Heavy Gear - Suspensor';
    case InfraRedGoggles = 'Infra-red Goggles';
    case IsotropicFuelRod = 'Isotropic Fuel Rod';
    case LoboChip = 'Lobo-chip';
    case MediPack = 'Medi-pack';
    case MungVase = 'Mung Vase';
    case PhotoContacts = 'Photo-contacts';
    case PhotoVisor = 'Photo-visor';
    case RaidGearScreamersOrStummers = 'Raid Gear - Screamers or Stummers';
    case RaidGearSilencer = 'Raid Gear - Silencer';
    case RareWeaponOneInAMillionWeapon = 'Rare Weapon - One in a Million Weapon';
    case RatskinMap = 'Ratskin Map';
    case Respirator = 'Respirator';
    case SkullChip = 'Skull Chip';
    case StingerPouch = 'Stinger Pouch';
    case WeaponReload = 'Weapon Reload';

    public function enumToString(): string
    {
        return match($this)
        {
            self::ArmourFlak => EquipementsEnum::ArmourFlak->value,
            self::ArmourMesh => EquipementsEnum::ArmourMesh->value,
            self::BerserkerChip => EquipementsEnum::BerserkerChip->value,
            self::BioBooster => EquipementsEnum::BioBooster->value,
            self::BioScanner => EquipementsEnum::BioScanner->value,
            self::BlindSnakePouch => EquipementsEnum::BlindSnakePouch->value,
            self::BionicArm => EquipementsEnum::BionicArm->value,
            self::BionicImplant => EquipementsEnum::BionicImplant->value,
            self::BionicLeg => EquipementsEnum::BionicLeg->value,
            self::BionicEye => EquipementsEnum::BionicEye->value,
            self::BionicTorso => EquipementsEnum::BionicTorso->value,
            self::ClipHarness => EquipementsEnum::ClipHarness->value,
            self::ConcealedBlade => EquipementsEnum::ConcealedBlade->value,
            self::ExoticArmourCarapace => EquipementsEnum::ExoticArmourCarapace->value,
            self::ExoticArmourForceField => EquipementsEnum::ExoticArmourForceField->value,
            self::FilterPlugs => EquipementsEnum::FilterPlugs->value,
            self::GravChute => EquipementsEnum::GravChute->value,
            self::Grapnel => EquipementsEnum::Grapnel->value,
            self::GunsightInfraRedSight => EquipementsEnum::GunsightInfraRedSight->value,
            self::GunsightMonoSight => EquipementsEnum::GunsightMonoSight->value,
            self::GunsightRedDotLaser => EquipementsEnum::GunsightRedDotLaser->value,
            self::GunsightTelescopicSight => EquipementsEnum::GunsightTelescopicSight->value,
            self::HeavyGearAutoRepairer => EquipementsEnum::HeavyGearAutoRepairer->value,
            self::HeavyGearSuspensor => EquipementsEnum::HeavyGearSuspensor->value,
            self::InfraRedGoggles => EquipementsEnum::InfraRedGoggles->value,
            self::IsotropicFuelRod => EquipementsEnum::IsotropicFuelRod->value,
            self::LoboChip => EquipementsEnum::LoboChip->value,
            self::MediPack => EquipementsEnum::MediPack->value,
            self::MungVase => EquipementsEnum::MungVase->value,
            self::PhotoContacts => EquipementsEnum::PhotoContacts->value,
            self::PhotoVisor => EquipementsEnum::PhotoVisor->value,
            self::RaidGearScreamersOrStummers => EquipementsEnum::RaidGearScreamersOrStummers->value,
            self::RaidGearSilencer => EquipementsEnum::RaidGearSilencer->value,
            self::RareWeaponOneInAMillionWeapon => EquipementsEnum::RareWeaponOneInAMillionWeapon->value,
            self::RatskinMap => EquipementsEnum::RatskinMap->value,
            self::Respirator => EquipementsEnum::Respirator->value,
            self::SkullChip => EquipementsEnum::SkullChip->value,
            self::StingerPouch => EquipementsEnum::StingerPouch->value,
            self::WeaponReload => EquipementsEnum::WeaponReload->value,
        };
    }

    public function getFixedCost(): int
    {
        return match($this)
        {
            self::ArmourFlak => 10,
            self::ArmourMesh => 25,
            self::BerserkerChip => 25,
            self::BioBooster => 40,
            self::BioScanner => 50,
            self::BionicArm => 80,
            self::BionicImplant => 50,
            self::BionicLeg => 80,
            self::BionicEye => 50,
            self::BionicTorso => 50,
            self::BlindSnakePouch => 30,
            self::ClipHarness => 10,
            self::ConcealedBlade => 10,
            self::ExoticArmourCarapace => 60,
            self::ExoticArmourForceField => 100,
            self::FilterPlugs => 10,
            self::GravChute => 40,
            self::Grapnel => 30,
            self::GunsightInfraRedSight => 30,
            self::GunsightMonoSight => 40,
            self::GunsightRedDotLaser => 40,
            self::GunsightTelescopicSight => 20,
            self::HeavyGearAutoRepairer => 80,
            self::HeavyGearSuspensor => 50,
            self::InfraRedGoggles => 30,
            self::IsotropicFuelRod => 50,
            self::LoboChip => 20,
            self::MediPack => 80,
            self::MungVase => 0,
            self::PhotoContacts => 15,
            self::PhotoVisor => 25,
            self::RaidGearScreamersOrStummers => 10,
            self::RaidGearSilencer => 10,
            self::RareWeaponOneInAMillionWeapon => 0,
            self::RatskinMap => 0,
            self::Respirator => 15,
            self::SkullChip => 30,
            self::StingerPouch => 10,
            self::WeaponReload => 0,
        };
    }

    public function getVariableDicesNumber(): int
    {
        return match($this)
        {
            self::ArmourFlak => 2,
            self::ArmourMesh => 2,
            self::BerserkerChip => 3,
            self::BioBooster => 4,
            self::BioScanner => 3,
            self::BionicArm => 3,
            self::BionicImplant => 3,
            self::BionicLeg => 3,
            self::BionicEye => 3,
            self::BionicTorso => 3,
            self::BlindSnakePouch => 2,
            self::ClipHarness => 0,
            self::ConcealedBlade => 1,
            self::ExoticArmourCarapace => 3,
            self::ExoticArmourForceField => 4,
            self::FilterPlugs => 0,
            self::GravChute => 4,
            self::Grapnel => 4,
            self::GunsightInfraRedSight => 3,
            self::GunsightMonoSight => 3,
            self::GunsightRedDotLaser => 3,
            self::GunsightTelescopicSight => 3,
            self::HeavyGearAutoRepairer => 4,
            self::HeavyGearSuspensor => 3,
            self::InfraRedGoggles => 3,
            self::IsotropicFuelRod => 4,
            self::LoboChip => 0,
            self::MediPack => 4,
            self::MungVase => 0,
            self::PhotoContacts => 0,
            self::PhotoVisor => 2,
            self::RaidGearScreamersOrStummers => 3,
            self::RaidGearSilencer => 2,
            self::RareWeaponOneInAMillionWeapon => 0,
            self::RatskinMap => 0,
            self::Respirator => 2,
            self::SkullChip => 3,
            self::StingerPouch => 3,
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

    public function isCustomRules(): bool
    {
        return match($this)
        {
            self::ClipHarness => false,
            self::FilterPlugs => false,
            self::LoboChip => false,
            self::PhotoContacts =>false,
            self::WeaponReload => false,
        };
    }
    public function getType(): string
    {
        return match($this)
        {
            self::ArmourFlak => self::ARMORS,
            self::ArmourMesh => self::ARMORS,
            self::BerserkerChip => self::BIONICS,
            self::BioBooster => self::PERSONAL_EQUIPMENT,
            self::BioScanner => self::PERSONAL_EQUIPMENT,
            self::BionicArm => self::BIONICS,
            self::BionicImplant => self::BIONICS,
            self::BionicLeg => self::BIONICS,
            self::BionicEye => self::BIONICS,
            self::BionicTorso => self::BIONICS,
            self::BlindSnakePouch => self::PERSONAL_EQUIPMENT,
            self::ClipHarness => self::PERSONAL_EQUIPMENT,
            self::ConcealedBlade => self::PERSONAL_EQUIPMENT,
            self::ExoticArmourCarapace => self::ARMORS,
            self::ExoticArmourForceField => self::ARMORS,
            self::FilterPlugs => self::PERSONAL_EQUIPMENT,
            self::GravChute => self::PERSONAL_EQUIPMENT,
            self::Grapnel => self::PERSONAL_EQUIPMENT,
            self::GunsightInfraRedSight => self::WEAPON_EQUIPEMENT,
            self::GunsightMonoSight => self::WEAPON_EQUIPEMENT,
            self::GunsightRedDotLaser => self::WEAPON_EQUIPEMENT,
            self::GunsightTelescopicSight => self::WEAPON_EQUIPEMENT,
            self::HeavyGearAutoRepairer => self::GANG_EQUIPEMENT,
            self::HeavyGearSuspensor => self::GANG_EQUIPEMENT,
            self::InfraRedGoggles => self::WEAPON_EQUIPEMENT,
            self::IsotropicFuelRod => self::GANG_EQUIPEMENT,
            self::LoboChip => self::BIONICS,
            self::MediPack => self::PERSONAL_EQUIPMENT,
            self::MungVase => self::GANG_EQUIPEMENT,
            self::PhotoContacts => self::PERSONAL_EQUIPMENT,
            self::PhotoVisor => self::PERSONAL_EQUIPMENT,
            self::RaidGearScreamersOrStummers => self::GANG_EQUIPEMENT,
            self::RaidGearSilencer => self::WEAPON_EQUIPEMENT,
            self::RatskinMap => self::GANG_EQUIPEMENT,
            self::RareWeaponOneInAMillionWeapon => self::WEAPON_EQUIPEMENT,
            self::Respirator => self::PERSONAL_EQUIPMENT,
            self::SkullChip => self::BIONICS,
            self::StingerPouch => self::PERSONAL_EQUIPMENT,
            self::WeaponReload => self::WEAPON_EQUIPEMENT,
        };
    }
}