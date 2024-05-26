<?php

declare(strict_types=1);

namespace App\Enum;

enum WeaponsEnum: string
{
    // Pistols
    case STUB_GUN = 'Stub Gun';
    case AUTOPISTOL = 'Autopistol';
    case LASPISTOL = 'Laspistol';
    case HAND_FLAMER = 'Hand Flamer';
    case BOLT_PISTOL = 'Bolt Pistol';
    case PLASMA_PISTOL = 'Plasma Pistol';
    case NEEDLE_PISTOL = 'Needle Pistol';
    case WEB_PISTOL = 'Web Pistol';
    // Basic Weapons
    case AUTOGUN = 'Autogun';
    case SHOTGUN_SOLID_SLUG = 'Shotgun (Solid Slug)';
    case SHOTGUN_SCATTER_SHOT = 'Shotgun (Scatter Shot)';
    case SHOTGUN_MANSTOPPER = 'Shotgun (Manstopper)';
    case SHOTGUN_HOT_SHOT = 'Shotgun (Hot Shot)';
    case SHOTGUN_BOLT = 'Shotgun (Bolt)';
    case HUNTING_RIFLE = 'Hunting Rifle';
    case LASGUN = 'Lasgun';
    case BOLTGUN = 'Boltgun';
    // Special Weapons
    case AUTOSLUGGER = 'Autoslugger';
    case FLAMER = 'Flamer';
    case GRENADE_LAUNCHER = 'Grenade Launcher';
    case PLASMA_GUN = 'Plasma Gun';
    case MELTAGUN = 'Meltagun';
    case NEEDLE_RIFLE = 'Needle Rifle';
    // Heavy Weapons
    case HEAVY_FLAMER = 'Heavy Flamer';
    case HEAVY_STUBBER = 'Heavy Stubber';
    case HEAVY_BOLTER = 'Heavy Bolter';
    case MISSILE_LAUNCHER_FRAG = 'Missile Launcher (Frag)';
    case MISSILE_LAUNCHER_KRAK = 'Missile Launcher (Krak)';
    case HEAVY_PLASMA_GUN = 'Heavy Plasma Gun';
    case AUTOCANNON = 'Autocannon';
    case LASCANNON = 'Lascannon';
    // Hand-to-Hand Weapons
    case KNIFE = 'Knife';
    case CHAIN_FLAIL = 'Chain, Flail';
    case CLUB_MAUL_BLUDGEON = 'Club, Maul, Bludgeon';
    case MASSIVE_WEAPON = 'Massive Weapon';
    case SWORD = 'Sword';
    case CHAIN_SWORD = 'Chainsword';
    case POWER_AXE = 'Power Axe';
    case SHOCK_MAUL = 'Shock Maul';
    case POWER_SWORD = 'Power Sword';
    case POWER_FIST = 'Power Fist';
    // Grenades
    case SMOKE_BOMBS = 'Smoke Bombs';
    case CHOKE_GAS = 'Choke Gas';
    case SCARE_GAS = 'Scare Gas';
    case PHOTON_FLARES = 'Photon Flares';
    case FRAG_GRENADE = 'Frag Grenade';
    case PLASMA_GRENADE = 'Plasma Grenade';
    case KRAK_GRENADE = 'Krak Grenade';
    case MELTA_BOMBS = 'Melta Bombs';
    case HALLUCINOGEN_GAS = 'Hallucinogen Gas';

    function enumToString(): string
    {
        return match ($this) {
            // Pistols
            WeaponsEnum::STUB_GUN => WeaponsEnum::STUB_GUN->value,
            WeaponsEnum::AUTOPISTOL => WeaponsEnum::AUTOPISTOL->value,
            WeaponsEnum::LASPISTOL => WeaponsEnum::LASPISTOL->value,
            WeaponsEnum::HAND_FLAMER => WeaponsEnum::HAND_FLAMER->value,
            WeaponsEnum::BOLT_PISTOL =>  WeaponsEnum::BOLT_PISTOL->value,
            WeaponsEnum::PLASMA_PISTOL => WeaponsEnum::PLASMA_PISTOL->value,
            WeaponsEnum::NEEDLE_PISTOL => WeaponsEnum::NEEDLE_PISTOL->value,
            WeaponsEnum::WEB_PISTOL => WeaponsEnum::WEB_PISTOL->value,
            // Basic Weapons
            WeaponsEnum::AUTOGUN =>  WeaponsEnum::AUTOGUN->value,
            WeaponsEnum::SHOTGUN_SOLID_SLUG =>  WeaponsEnum::SHOTGUN_SOLID_SLUG->value,
            WeaponsEnum::SHOTGUN_SCATTER_SHOT => WeaponsEnum::SHOTGUN_SCATTER_SHOT->value,
            WeaponsEnum::SHOTGUN_MANSTOPPER =>  WeaponsEnum::SHOTGUN_MANSTOPPER->value,
            WeaponsEnum::SHOTGUN_HOT_SHOT => WeaponsEnum::SHOTGUN_HOT_SHOT->value,
            WeaponsEnum::SHOTGUN_BOLT => WeaponsEnum::SHOTGUN_BOLT->value,
            WeaponsEnum::HUNTING_RIFLE =>  WeaponsEnum::HUNTING_RIFLE->value,
            WeaponsEnum::LASGUN => WeaponsEnum::LASGUN->value,
            WeaponsEnum::BOLTGUN => WeaponsEnum::BOLTGUN->value,
            // Special Weapons
            WeaponsEnum::AUTOSLUGGER => WeaponsEnum::AUTOSLUGGER->value,
            WeaponsEnum::FLAMER => WeaponsEnum::FLAMER->value,
            WeaponsEnum::GRENADE_LAUNCHER => WeaponsEnum::GRENADE_LAUNCHER->value,
            WeaponsEnum::PLASMA_GUN => WeaponsEnum::PLASMA_GUN->value,
            WeaponsEnum::MELTAGUN => WeaponsEnum::MELTAGUN->value,
            WeaponsEnum::NEEDLE_RIFLE => WeaponsEnum::NEEDLE_RIFLE->value,
            // Heavy Weapons
            WeaponsEnum::HEAVY_FLAMER => WeaponsEnum::HEAVY_FLAMER->value,
            WeaponsEnum::HEAVY_STUBBER => WeaponsEnum::HEAVY_STUBBER->value,
            WeaponsEnum::HEAVY_BOLTER => WeaponsEnum::HEAVY_BOLTER->value,
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => WeaponsEnum::MISSILE_LAUNCHER_FRAG->value,
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => WeaponsEnum::MISSILE_LAUNCHER_KRAK->value,
            WeaponsEnum::HEAVY_PLASMA_GUN => WeaponsEnum::HEAVY_PLASMA_GUN->value,
            WeaponsEnum::AUTOCANNON => WeaponsEnum::AUTOCANNON->value,
            WeaponsEnum::LASCANNON => WeaponsEnum::LASCANNON->value,
            // Hand-to-Hand Weapons
            WeaponsEnum::KNIFE =>  WeaponsEnum::KNIFE->value,
            WeaponsEnum::CHAIN_FLAIL => WeaponsEnum::CHAIN_FLAIL->value,
            WeaponsEnum::CLUB_MAUL_BLUDGEON => WeaponsEnum::CLUB_MAUL_BLUDGEON->value,
            WeaponsEnum::MASSIVE_WEAPON => WeaponsEnum::MASSIVE_WEAPON->value,
            WeaponsEnum::SWORD => WeaponsEnum::SWORD->value,
            WeaponsEnum::CHAIN_SWORD => WeaponsEnum::CHAIN_SWORD->value,
            WeaponsEnum::POWER_AXE => WeaponsEnum::POWER_AXE->value,
            WeaponsEnum::SHOCK_MAUL =>  WeaponsEnum::SHOCK_MAUL->value,
            WeaponsEnum::POWER_SWORD => WeaponsEnum::POWER_SWORD->value,
            WeaponsEnum::POWER_FIST => WeaponsEnum::POWER_FIST->value,
            // Grenades
            WeaponsEnum::SMOKE_BOMBS => WeaponsEnum::POWER_FIST->value,
            WeaponsEnum::CHOKE_GAS => WeaponsEnum::CHOKE_GAS->value,
            WeaponsEnum::SCARE_GAS => WeaponsEnum::SCARE_GAS->value,
            WeaponsEnum::PHOTON_FLARES => WeaponsEnum::PHOTON_FLARES->value,
            WeaponsEnum::FRAG_GRENADE => WeaponsEnum::FRAG_GRENADE->value,
            WeaponsEnum::PLASMA_GRENADE => WeaponsEnum::PLASMA_GRENADE->value,
            WeaponsEnum::KRAK_GRENADE => WeaponsEnum::KRAK_GRENADE->value,
            WeaponsEnum::MELTA_BOMBS => WeaponsEnum::MELTA_BOMBS->value,
            WeaponsEnum::HALLUCINOGEN_GAS => WeaponsEnum::HALLUCINOGEN_GAS->value,
        };
    }

    function getWeaponType(): string
    {
        return match ($this) {
            // Pistols
            WeaponsEnum::STUB_GUN => 'Pistols',
            WeaponsEnum::AUTOPISTOL => 'Pistols',
            WeaponsEnum::LASPISTOL => 'Pistols',
            WeaponsEnum::HAND_FLAMER => 'Pistols',
            WeaponsEnum::BOLT_PISTOL => 'Pistols',
            WeaponsEnum::PLASMA_PISTOL => 'Pistols',
            WeaponsEnum::NEEDLE_PISTOL => 'Pistols',
            WeaponsEnum::WEB_PISTOL => 'Pistols',
            // Basic Weapons
            WeaponsEnum::AUTOGUN => 'Basic weapons',
            WeaponsEnum::SHOTGUN_SOLID_SLUG => 'Basic weapons',
            WeaponsEnum::SHOTGUN_SCATTER_SHOT => 'Basic weapons',
            WeaponsEnum::SHOTGUN_MANSTOPPER => 'Basic weapons',
            WeaponsEnum::SHOTGUN_HOT_SHOT => 'Basic weapons',
            WeaponsEnum::SHOTGUN_BOLT => 'Basic weapons',
            WeaponsEnum::HUNTING_RIFLE => 'Basic weapons',
            WeaponsEnum::LASGUN => 'Basic weapons',
            WeaponsEnum::BOLTGUN => 'Basic weapons',
            // Special Weapons
            WeaponsEnum::AUTOSLUGGER => 'Special weapons',
            WeaponsEnum::FLAMER => 'Special weapons',
            WeaponsEnum::GRENADE_LAUNCHER => 'Special weapons',
            WeaponsEnum::PLASMA_GUN => 'Special weapons',
            WeaponsEnum::MELTAGUN => 'Special weapons',
            WeaponsEnum::NEEDLE_RIFLE => 'Special weapons',
            // Heavy Weapons
            WeaponsEnum::HEAVY_FLAMER => 'Heavy weapons',
            WeaponsEnum::HEAVY_STUBBER => 'Heavy weapons',
            WeaponsEnum::HEAVY_BOLTER => 'Heavy weapons',
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => 'Heavy weapons',
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => 'Heavy weapons',
            WeaponsEnum::HEAVY_PLASMA_GUN => 'Heavy weapons',
            WeaponsEnum::AUTOCANNON => 'Heavy weapons',
            WeaponsEnum::LASCANNON => 'Heavy weapons',
            // Hand-to-Hand Weapons
            WeaponsEnum::KNIFE => 'Hand-to-hands weapons',
            WeaponsEnum::CHAIN_FLAIL => 'Hand-to-hands weapons',
            WeaponsEnum::CLUB_MAUL_BLUDGEON => 'Hand-to-hands weapons',
            WeaponsEnum::MASSIVE_WEAPON => 'Hand-to-hands weapons',
            WeaponsEnum::SWORD => 'Hand-to-hands weapons',
            WeaponsEnum::CHAIN_SWORD => 'Hand-to-hands weapons',
            WeaponsEnum::POWER_AXE => 'Hand-to-hands weapons',
            WeaponsEnum::SHOCK_MAUL => 'Hand-to-hands weapons',
            WeaponsEnum::POWER_SWORD => 'Hand-to-hands weapons',
            WeaponsEnum::POWER_FIST => 'Hand-to-hands weapons',
            // Grenades
            WeaponsEnum::SMOKE_BOMBS => 'Grenades',
            WeaponsEnum::CHOKE_GAS => 'Grenades',
            WeaponsEnum::SCARE_GAS => 'Grenades',
            WeaponsEnum::PHOTON_FLARES => 'Grenades',
            WeaponsEnum::FRAG_GRENADE => 'Grenades',
            WeaponsEnum::PLASMA_GRENADE => 'Grenades',
            WeaponsEnum::KRAK_GRENADE => 'Grenades',
            WeaponsEnum::MELTA_BOMBS => 'Grenades',
            WeaponsEnum::HALLUCINOGEN_GAS => 'Grenades',
        };
    }

    function getWeaponFixedCost(): int
    {
        return match ($this) {
            // Pistols
            WeaponsEnum::STUB_GUN => 120,
            WeaponsEnum::AUTOPISTOL => 15,
            WeaponsEnum::LASPISTOL => 15,
            WeaponsEnum::HAND_FLAMER => 25,
            WeaponsEnum::BOLT_PISTOL => 25,
            WeaponsEnum::PLASMA_PISTOL => 30,
            WeaponsEnum::NEEDLE_PISTOL => 80,
            WeaponsEnum::WEB_PISTOL => 120,
            // Basic Weapons
            WeaponsEnum::AUTOGUN => 20,
            WeaponsEnum::SHOTGUN_SOLID_SLUG => 20,
            WeaponsEnum::SHOTGUN_SCATTER_SHOT => 20,
            WeaponsEnum::SHOTGUN_MANSTOPPER => 25,
            WeaponsEnum::SHOTGUN_HOT_SHOT => 25,
            WeaponsEnum::SHOTGUN_BOLT => 35,
            WeaponsEnum::HUNTING_RIFLE => 25,
            WeaponsEnum::LASGUN => 25,
            WeaponsEnum::BOLTGUN => 35,
            // Special Weapons
            WeaponsEnum::AUTOSLUGGER => 45,
            WeaponsEnum::FLAMER => 40,
            WeaponsEnum::GRENADE_LAUNCHER => 60,
            WeaponsEnum::PLASMA_GUN => 80,
            WeaponsEnum::MELTAGUN => 95,
            WeaponsEnum::NEEDLE_RIFLE => 180,
            // Heavy Weapons
            WeaponsEnum::HEAVY_FLAMER => 80,
            WeaponsEnum::HEAVY_STUBBER => 120,
            WeaponsEnum::HEAVY_BOLTER => 180,
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => 175,
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => 190,
            WeaponsEnum::HEAVY_PLASMA_GUN => 240,
            WeaponsEnum::AUTOCANNON => 260,
            WeaponsEnum::LASCANNON => 300,
            // Hand-to-Hand Weapons
            WeaponsEnum::KNIFE => 5,
            WeaponsEnum::CHAIN_FLAIL => 10,
            WeaponsEnum::CLUB_MAUL_BLUDGEON => 10,
            WeaponsEnum::MASSIVE_WEAPON => 15,
            WeaponsEnum::SWORD => 15,
            WeaponsEnum::CHAIN_SWORD => 25,
            WeaponsEnum::POWER_AXE => 35,
            WeaponsEnum::SHOCK_MAUL => 35,
            WeaponsEnum::POWER_SWORD => 40,
            WeaponsEnum::POWER_FIST => 85,
            // Grenades
            WeaponsEnum::SMOKE_BOMBS => 10,
            WeaponsEnum::CHOKE_GAS => 15,
            WeaponsEnum::SCARE_GAS => 20,
            WeaponsEnum::PHOTON_FLARES => 20,
            WeaponsEnum::FRAG_GRENADE => 25,
            WeaponsEnum::PLASMA_GRENADE => 35,
            WeaponsEnum::KRAK_GRENADE => 40,
            WeaponsEnum::MELTA_BOMBS => 40,
            WeaponsEnum::HALLUCINOGEN_GAS => 40,
        };
    }

    function getWeaponVariableCostDiceNumber(): int
    {
        return match ($this) {
            // Pistols
            WeaponsEnum::STUB_GUN => 0,
            WeaponsEnum::AUTOPISTOL => 0,
            WeaponsEnum::LASPISTOL => 0,
            WeaponsEnum::HAND_FLAMER => 0,
            WeaponsEnum::BOLT_PISTOL => 0,
            WeaponsEnum::PLASMA_PISTOL => 0,
            WeaponsEnum::NEEDLE_PISTOL => 4,
            WeaponsEnum::WEB_PISTOL => 4,
            // Basic Weapons
            WeaponsEnum::AUTOGUN => 0,
            WeaponsEnum::SHOTGUN_SOLID_SLUG => 0,
            WeaponsEnum::SHOTGUN_SCATTER_SHOT => 0,
            WeaponsEnum::SHOTGUN_MANSTOPPER => 0,
            WeaponsEnum::SHOTGUN_HOT_SHOT => 0,
            WeaponsEnum::SHOTGUN_BOLT => 0,
            WeaponsEnum::HUNTING_RIFLE => 0,
            WeaponsEnum::LASGUN => 0,
            WeaponsEnum::BOLTGUN => 0,
            // Special Weapons
            WeaponsEnum::AUTOSLUGGER => 0,
            WeaponsEnum::FLAMER => 0,
            WeaponsEnum::GRENADE_LAUNCHER => 0,
            WeaponsEnum::PLASMA_GUN => 0,
            WeaponsEnum::MELTAGUN => 0,
            WeaponsEnum::NEEDLE_RIFLE => 4,
            // Heavy Weapons
            WeaponsEnum::HEAVY_FLAMER => 0,
            WeaponsEnum::HEAVY_STUBBER => 0,
            WeaponsEnum::HEAVY_BOLTER => 0,
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => 0,
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => 0,
            WeaponsEnum::HEAVY_PLASMA_GUN => 0,
            WeaponsEnum::AUTOCANNON => 0,
            WeaponsEnum::LASCANNON => 0,
            // Hand-to-Hand Weapons
            WeaponsEnum::KNIFE => 0,
            WeaponsEnum::CHAIN_FLAIL => 0,
            WeaponsEnum::CLUB_MAUL_BLUDGEON => 0,
            WeaponsEnum::MASSIVE_WEAPON => 0,
            WeaponsEnum::SWORD => 0,
            WeaponsEnum::CHAIN_SWORD => 0,
            WeaponsEnum::POWER_AXE => 3,
            WeaponsEnum::SHOCK_MAUL => 3,
            WeaponsEnum::POWER_SWORD => 3,
            WeaponsEnum::POWER_FIST => 3,
            // Grenades
            WeaponsEnum::SMOKE_BOMBS => 3,
            WeaponsEnum::CHOKE_GAS => 2,
            WeaponsEnum::SCARE_GAS => 2,
            WeaponsEnum::PHOTON_FLARES => 2,
            WeaponsEnum::FRAG_GRENADE => 0,
            WeaponsEnum::PLASMA_GRENADE => 3,
            WeaponsEnum::KRAK_GRENADE => 0,
            WeaponsEnum::MELTA_BOMBS => 3,
            WeaponsEnum::HALLUCINOGEN_GAS => 4,
        };
    }
}