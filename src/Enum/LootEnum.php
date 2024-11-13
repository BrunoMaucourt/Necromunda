<?php

declare(strict_types=1);

namespace App\Enum;

enum LootEnum: string
{
    const EQUIPMENT_FOR_GANGER = 'Equipment for ganger';
    const EQUIPMENT_FOR_WEAPON = 'Equipment for weapon';
    const WEAPON = 'Weapon';

    case PowerWeaponPowerSword = 'Power Weapon - Power Sword';
    case PowerWeaponPowerAxe = 'Power Weapon - Power Axe';
    case PowerWeaponPowerFist = 'Power Weapon - Power Fist';

    case RareWeaponNeedleRifle = 'Rare Weapon - Needle Rifle';
    case RareWeaponNeedlePistol = 'Rare Weapon - Needle Pistol';
    case RareWeaponWebPistol = 'Rare Weapon - Web Pistol';
    case RareWeaponOneInAMillionWeapon = 'Rare Weapon - One in a Million Weapon';

    case GasGrenadesChoke = 'Gas Grenades - Choke';
    case GasGrenadesScare = 'Gas Grenades - Scare';
    case GasGrenadesHallucinogen = 'Gas Grenades - Hallucinogen';

    case GrenadesMeltaBombs = 'Grenades - Melta Bombs';
    case GrenadesPhotonFlashFlares = 'Grenades - Photon Flash Flares';
    case GrenadesPlasmaGrenades = 'Grenades - Plasma Grenades';
    case GrenadesSmokeBombs = 'Grenades - Smoke Bombs';

    case AmmoHotshotLaserPowerPacks = 'Ammo - Hotshot Laser Power Packs';
    case AmmoDrumMagazine = 'Ammo - Drum Magazine';
    case AmmoHellfireBolts = 'Ammo - Hellfire Bolts';

    case GunsightRedDotLaser = 'Gunsight - Red-dot Laser';
    case GunsightMonoSight = 'Gunsight - Mono-sight';
    case GunsightTelescopicSight = 'Gunsight - Telescopic Sight';
    case GunsightInfraRedSight = 'Gunsight - Infra-red Sight';

    case HeavyGearAutoRepairer = 'Heavy Gear - Auto-repairer';
    case HeavyGearSuspensor = 'Heavy Gear - Suspensor';

    case ArmourFlak = 'Armour - Flak';
    case ArmourMesh = 'Armour - Mesh';
    case ExoticArmourCarapace = 'Exotic Armour - Carapace';
    case ExoticArmourForceField = 'Exotic Armour - Force Field';

    case MediPack = 'Medi-pack';
    case IsotropicFuelRod = 'Isotropic Fuel Rod';

    case Bionic = 'Bionic - Arm, Eye, Leg, Chest, Implant';

    case SkullChip = 'Skull Chip';
    case ShockMaul = 'Shock Maul';
    case Grapnel = 'Grapnel';
    case GravChute = 'Grav Chute';
    case BioScanner = 'Bio-scanner';
    case BioBooster = 'Bio-booster';

    case ConcealedBlade = 'Concealed Blade';
    case Respirator = 'Respirator';
    case PhotoVisor = 'Photo-visor';
    case BerserkerChip = 'Berserker Chip';
    case BlindSnakePouch = 'Blindsnake Pouch';
    case InfraRedGoggles = 'Infra-red Goggles';

    case RaidGearSilencer = 'Raid Gear - Silencer';
    case RaidGearScreamersOrStummers = 'Raid Gear - Screamers or Stummers';

    case StingerPouch = 'Stinger Pouch';
    case RatskinMap = 'Ratskin Map';
    case MungVase = 'Mung Vase';

    public function enumToString(): string
    {
        return match($this) {
            self::PowerWeaponPowerSword => LootEnum::PowerWeaponPowerSword->value,
            self::PowerWeaponPowerAxe => LootEnum::PowerWeaponPowerAxe->value,
            self::PowerWeaponPowerFist => LootEnum::PowerWeaponPowerFist->value,
            self::RareWeaponNeedleRifle => LootEnum::RareWeaponNeedleRifle->value,
            self::RareWeaponNeedlePistol => LootEnum::RareWeaponNeedlePistol->value,
            self::RareWeaponWebPistol => LootEnum::RareWeaponWebPistol->value,
            self::RareWeaponOneInAMillionWeapon => LootEnum::RareWeaponOneInAMillionWeapon->value,
            self::GasGrenadesChoke => LootEnum::GasGrenadesChoke->value,
            self::GasGrenadesScare => LootEnum::GasGrenadesScare->value,
            self::GasGrenadesHallucinogen => LootEnum::GasGrenadesHallucinogen->value,
            self::GrenadesMeltaBombs => LootEnum::GrenadesMeltaBombs->value,
            self::GrenadesPhotonFlashFlares => LootEnum::GrenadesPhotonFlashFlares->value,
            self::GrenadesPlasmaGrenades => LootEnum::GrenadesPlasmaGrenades->value,
            self::GrenadesSmokeBombs => LootEnum::GrenadesSmokeBombs->value,
            self::AmmoHotshotLaserPowerPacks => LootEnum::AmmoHotshotLaserPowerPacks->value,
            self::AmmoDrumMagazine => LootEnum::AmmoDrumMagazine->value,
            self::AmmoHellfireBolts => LootEnum::AmmoHellfireBolts->value,
            self::GunsightRedDotLaser => LootEnum::GunsightRedDotLaser->value,
            self::GunsightMonoSight => LootEnum::GunsightMonoSight->value,
            self::GunsightTelescopicSight => LootEnum::GunsightTelescopicSight->value,
            self::GunsightInfraRedSight => LootEnum::GunsightInfraRedSight->value,
            self::HeavyGearAutoRepairer => LootEnum::HeavyGearAutoRepairer->value,
            self::HeavyGearSuspensor => LootEnum::HeavyGearSuspensor->value,
            self::ArmourFlak => LootEnum::ArmourFlak->value,
            self::ArmourMesh => LootEnum::ArmourMesh->value,
            self::ExoticArmourCarapace => LootEnum::ExoticArmourCarapace->value,
            self::ExoticArmourForceField => LootEnum::ExoticArmourForceField->value,
            self::MediPack => LootEnum::MediPack->value,
            self::IsotropicFuelRod => LootEnum::IsotropicFuelRod->value,
            self::Bionic => LootEnum::Bionic->value,
            self::SkullChip => LootEnum::SkullChip->value,
            self::ShockMaul => LootEnum::ShockMaul->value,
            self::Grapnel => LootEnum::Grapnel->value,
            self::GravChute => LootEnum::GravChute->value,
            self::BioScanner => LootEnum::BioScanner->value,
            self::BioBooster => LootEnum::BioBooster->value,
            self::ConcealedBlade => LootEnum::ConcealedBlade->value,
            self::Respirator => LootEnum::Respirator->value,
            self::PhotoVisor => LootEnum::PhotoVisor->value,
            self::BerserkerChip => LootEnum::BerserkerChip->value,
            self::BlindSnakePouch => LootEnum::BlindSnakePouch->value,
            self::InfraRedGoggles => LootEnum::InfraRedGoggles->value,
            self::RaidGearSilencer => LootEnum::RaidGearSilencer->value,
            self::RaidGearScreamersOrStummers => LootEnum::RaidGearScreamersOrStummers->value,
            self::StingerPouch => LootEnum::StingerPouch->value,
            self::RatskinMap => LootEnum::RatskinMap->value,
            self::MungVase => LootEnum::MungVase->value,
        };
    }

    public function getDicesRange(): string
    {
        return match($this) {
            self::PowerWeaponPowerSword => '111 - 113',
            self::PowerWeaponPowerAxe => '114-115',
            self::PowerWeaponPowerFist => '116-116',
            self::RareWeaponNeedleRifle => '121-121',
            self::RareWeaponNeedlePistol => '122-123',
            self::RareWeaponWebPistol => '124-125',
            self::RareWeaponOneInAMillionWeapon => '126-126',
            self::GasGrenadesChoke => '131-133,141-143',
            self::GasGrenadesScare => '134-135,144-145',
            self::GasGrenadesHallucinogen => '136-136,146-146',
            self::GrenadesMeltaBombs => '151-151,161-161',
            self::GrenadesPhotonFlashFlares => '152-153,162-163',
            self::GrenadesPlasmaGrenades => '154-154,164-164',
            self::GrenadesSmokeBombs => '155-156,165-166',
            self::AmmoHotshotLaserPowerPacks => '211-213,221-223,231-233',
            self::AmmoDrumMagazine => '214-215,224-225,234-235',
            self::AmmoHellfireBolts => '216-216,226-226,236-236',
            self::GunsightRedDotLaser => '241-242,251-252',
            self::GunsightMonoSight => '243-243,253-253',
            self::GunsightTelescopicSight => '244-245,254-255',
            self::GunsightInfraRedSight => '246-246,256-256',
            self::HeavyGearAutoRepairer => '261-264',
            self::HeavyGearSuspensor => '265-266',
            self::ArmourFlak => '311-313,321-323,331-333',
            self::ArmourMesh => '314-315,325-325,334-335',
            self::ExoticArmourCarapace => '3161-3164,3261-3264,3361-3364',
            self::ExoticArmourForceField => '3165-3166,3265-3266,3365-3366',
            self::MediPack => '34-34',
            self::IsotropicFuelRod => '35-35',
            self::Bionic => '36-36',
            self::SkullChip => '41-41',
            self::ShockMaul => '42-42',
            self::Grapnel => '43-43',
            self::GravChute => '44-44',
            self::BioScanner => '45-45',
            self::BioBooster => '46-46',
            self::ConcealedBlade => '51-51',
            self::Respirator => '52-52',
            self::PhotoVisor => '53-53',
            self::BerserkerChip => '54-54',
            self::BlindSnakePouch => '55-55',
            self::InfraRedGoggles => '56-56',
            self::RaidGearSilencer => '611-613,621-623,631-633',
            self::RaidGearScreamersOrStummers => '614-616,624-626,634-636',
            self::StingerPouch => '64-64',
            self::RatskinMap => '65-65',
            self::MungVase => '66-66',
        };
    }

    public function getFixedCost(): int
    {
        return match($this) {
            self::PowerWeaponPowerSword => 40,
            self::PowerWeaponPowerAxe => 35,
            self::PowerWeaponPowerFist => 85,
            self::RareWeaponNeedleRifle => 180,
            self::RareWeaponNeedlePistol => 80,
            self::RareWeaponWebPistol => 120,
            self::RareWeaponOneInAMillionWeapon => 0,
            self::GasGrenadesChoke => 15,
            self::GasGrenadesScare => 20,
            self::GasGrenadesHallucinogen => 40,
            self::GrenadesMeltaBombs => 40,
            self::GrenadesPhotonFlashFlares => 20,
            self::GrenadesPlasmaGrenades => 35,
            self::GrenadesSmokeBombs => 10,
            self::AmmoHotshotLaserPowerPacks => 15,
            self::AmmoDrumMagazine => 15,
            self::AmmoHellfireBolts => 20,
            self::GunsightRedDotLaser => 40,
            self::GunsightMonoSight => 40,
            self::GunsightTelescopicSight => 20,
            self::GunsightInfraRedSight => 30,
            self::HeavyGearAutoRepairer => 80,
            self::HeavyGearSuspensor => 50,
            self::ArmourFlak => 10,
            self::ArmourMesh => 25,
            self::ExoticArmourCarapace => 60,
            self::ExoticArmourForceField => 100,
            self::MediPack => 80,
            self::IsotropicFuelRod => 50,
            self::Bionic => 0,
            self::SkullChip => 30,
            self::ShockMaul => 35,
            self::Grapnel => 30,
            self::GravChute => 40,
            self::BioScanner => 50,
            self::BioBooster => 40,
            self::ConcealedBlade => 10,
            self::Respirator => 15,
            self::PhotoVisor => 25,
            self::BerserkerChip => 25,
            self::BlindSnakePouch => 30,
            self::InfraRedGoggles => 30,
            self::RaidGearSilencer => 10,
            self::RaidGearScreamersOrStummers => 10,
            self::StingerPouch => 10,
            self::RatskinMap => 0,
            self::MungVase => 0,
        };
    }
    public function getVariableDicesNumber(): int
    {
        return match($this) {
            self::PowerWeaponPowerSword => 3,
            self::PowerWeaponPowerAxe => 3,
            self::PowerWeaponPowerFist => 3,
            self::RareWeaponNeedleRifle => 4,
            self::RareWeaponNeedlePistol => 4,
            self::RareWeaponWebPistol => 4,
            self::RareWeaponOneInAMillionWeapon => 0,
            self::GasGrenadesChoke => 2,
            self::GasGrenadesScare => 2,
            self::GasGrenadesHallucinogen => 4,
            self::GrenadesMeltaBombs => 3,
            self::GrenadesPhotonFlashFlares => 2,
            self::GrenadesPlasmaGrenades => 3,
            self::GrenadesSmokeBombs => 3,
            self::AmmoHotshotLaserPowerPacks => 2,
            self::AmmoDrumMagazine => 2,
            self::AmmoHellfireBolts => 3,
            self::GunsightRedDotLaser => 3,
            self::GunsightMonoSight => 3,
            self::GunsightTelescopicSight => 3,
            self::GunsightInfraRedSight => 3,
            self::HeavyGearAutoRepairer => 4,
            self::HeavyGearSuspensor => 3,
            self::ArmourFlak => 2,
            self::ArmourMesh => 2,
            self::ExoticArmourCarapace => 3,
            self::ExoticArmourForceField => 4,
            self::MediPack => 4,
            self::IsotropicFuelRod => 4,
            self::Bionic => 0,
            self::SkullChip => 3,
            self::ShockMaul => 3,
            self::Grapnel => 4,
            self::GravChute => 4,
            self::BioScanner => 3,
            self::BioBooster => 4,
            self::ConcealedBlade => 1,
            self::Respirator => 2,
            self::PhotoVisor => 2,
            self::BerserkerChip => 3,
            self::BlindSnakePouch => 2,
            self::InfraRedGoggles => 3,
            self::RaidGearSilencer => 2,
            self::RaidGearScreamersOrStummers => 3,
            self::StingerPouch => 3,
            self::RatskinMap => 0,
            self::MungVase => 0,
        };
    }

    public function getType(): string
    {
        return match($this) {
            self::PowerWeaponPowerSword => self::WEAPON,
            self::PowerWeaponPowerAxe => self::WEAPON,
            self::PowerWeaponPowerFist => self::WEAPON,
            self::RareWeaponNeedleRifle => self::WEAPON,
            self::RareWeaponNeedlePistol => self::WEAPON,
            self::RareWeaponWebPistol => self::WEAPON,
            self::RareWeaponOneInAMillionWeapon => self::EQUIPMENT_FOR_WEAPON,
            self::GasGrenadesChoke => self::WEAPON,
            self::GasGrenadesScare => self::WEAPON,
            self::GasGrenadesHallucinogen => self::WEAPON,
            self::GrenadesMeltaBombs => self::WEAPON,
            self::GrenadesPhotonFlashFlares => self::WEAPON,
            self::GrenadesPlasmaGrenades => self::WEAPON,
            self::GrenadesSmokeBombs => self::WEAPON,
            self::AmmoHotshotLaserPowerPacks => self::WEAPON,
            self::AmmoDrumMagazine => self::EQUIPMENT_FOR_WEAPON,
            self::AmmoHellfireBolts => self::WEAPON,
            self::GunsightRedDotLaser => self::EQUIPMENT_FOR_WEAPON,
            self::GunsightMonoSight => self::EQUIPMENT_FOR_WEAPON,
            self::GunsightTelescopicSight => self::EQUIPMENT_FOR_WEAPON,
            self::GunsightInfraRedSight => self::EQUIPMENT_FOR_WEAPON,
            self::HeavyGearAutoRepairer => self::EQUIPMENT_FOR_GANGER,
            self::HeavyGearSuspensor => self::EQUIPMENT_FOR_GANGER,
            self::ArmourFlak => self::EQUIPMENT_FOR_GANGER,
            self::ArmourMesh => self::EQUIPMENT_FOR_GANGER,
            self::ExoticArmourCarapace => self::EQUIPMENT_FOR_GANGER,
            self::ExoticArmourForceField => self::EQUIPMENT_FOR_GANGER,
            self::MediPack => self::EQUIPMENT_FOR_GANGER,
            self::IsotropicFuelRod => self::EQUIPMENT_FOR_GANGER,
            self::Bionic => self::EQUIPMENT_FOR_GANGER,
            self::SkullChip => self::EQUIPMENT_FOR_GANGER,
            self::ShockMaul => self::WEAPON,
            self::Grapnel => self::EQUIPMENT_FOR_GANGER,
            self::GravChute => self::EQUIPMENT_FOR_GANGER,
            self::BioScanner => self::EQUIPMENT_FOR_GANGER,
            self::BioBooster => self::EQUIPMENT_FOR_GANGER,
            self::ConcealedBlade => self::EQUIPMENT_FOR_GANGER,
            self::Respirator => self::EQUIPMENT_FOR_GANGER,
            self::PhotoVisor => self::EQUIPMENT_FOR_GANGER,
            self::BerserkerChip => self::EQUIPMENT_FOR_GANGER,
            self::BlindSnakePouch => self::EQUIPMENT_FOR_GANGER,
            self::InfraRedGoggles => self::EQUIPMENT_FOR_GANGER,
            self::RaidGearSilencer => self::EQUIPMENT_FOR_WEAPON,
            self::RaidGearScreamersOrStummers => self::EQUIPMENT_FOR_GANGER,
            self::StingerPouch => self::EQUIPMENT_FOR_GANGER,
            self::RatskinMap => self::EQUIPMENT_FOR_GANGER,
            self::MungVase => self::EQUIPMENT_FOR_GANGER,
        };
    }

    public function getWeaponEnum(): WeaponsEnum
    {
        return match($this) {
            self::PowerWeaponPowerSword => WeaponsEnum::POWER_SWORD,
            self::PowerWeaponPowerAxe => WeaponsEnum::POWER_AXE,
            self::PowerWeaponPowerFist => WeaponsEnum::POWER_FIST,
            self::RareWeaponNeedleRifle => WeaponsEnum::NEEDLE_RIFLE,
            self::RareWeaponNeedlePistol => WeaponsEnum::NEEDLE_PISTOL,
            self::RareWeaponWebPistol => WeaponsEnum::WEB_PISTOL,
            self::GasGrenadesChoke => WeaponsEnum::CHOKE_GAS,
            self::GasGrenadesScare => WeaponsEnum::SCARE_GAS,
            self::GasGrenadesHallucinogen => WeaponsEnum::HALLUCINOGEN_GAS,
            self::GrenadesMeltaBombs => WeaponsEnum::MELTA_BOMBS,
            self::GrenadesPhotonFlashFlares => WeaponsEnum::PHOTON_FLARES,
            self::GrenadesPlasmaGrenades => WeaponsEnum::PLASMA_GRENADE,
            self::GrenadesSmokeBombs => WeaponsEnum::SMOKE_BOMBS,
            self::AmmoHotshotLaserPowerPacks => WeaponsEnum::HOT_SHOT_SHELLS,
            self::AmmoHellfireBolts => WeaponsEnum::HOT_SHOT_SHELLS,
            self::ShockMaul => WeaponsEnum::SHOCK_MAUL,
        };
    }
}