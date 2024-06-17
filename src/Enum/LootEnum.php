<?php

declare(strict_types=1);

namespace App\Enum;

enum LootEnum: string
{
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
}