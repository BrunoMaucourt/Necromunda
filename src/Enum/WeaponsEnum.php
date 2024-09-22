<?php

declare(strict_types=1);

namespace App\Enum;

use App\Contract\ItemEnumInterface;

enum WeaponsEnum: string implements ItemEnumInterface
{
    const PISTOLS = 'Pistols';
    const BASIC_WEAPONS = 'Basic weapons';
    const SPECIAL_WEAPONS = 'Special weapons';
    const HEAVY_WEAPONS = 'Heavy weapons';
    const HAND_TO_HANDS_WEAPONS = 'Hand-to-hands weapons';
    const GRENADES = 'Grenades';
    const SPECIAL_AMNUMITIONS = 'Special ammunitions';
    const ENFONCERS = 'Enfoncer weapons';

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
    case MISSILE_LAUNCHER = 'Missile Launcher';
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
    case FLARE_ROCKET = 'Flare Rocket';

    // Special Ammunitions
    case BOLT_SHELLS = 'Bolt shells';
    case DUM_DUM_BULLETS = 'Dum Dum Bullets';
    case HOT_SHOT_SHELLS = 'Hot shot shells';
    case MANSTOPPER_SHELLS = 'Manstopper Shells';
    case MISSILE_LAUNCHER_FRAG = 'Missile Launcher (Frag)';
    case MISSILE_LAUNCHER_KRAK = 'Missile Launcher (Krak)';

    // Enfoncers
    case COMBAT_RIFLE = 'Combat Rifle';
    case EXECUTIONER_SHELLS = 'Executioner shells';
    case SUPPRESSIVE_SHIELD = 'Suppressive Shield';
    case WEB_LAUNCHER = 'Web Launcher';

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
            WeaponsEnum::MISSILE_LAUNCHER => WeaponsEnum::MISSILE_LAUNCHER->value,
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
            WeaponsEnum::SMOKE_BOMBS => WeaponsEnum::SMOKE_BOMBS->value,
            WeaponsEnum::CHOKE_GAS => WeaponsEnum::CHOKE_GAS->value,
            WeaponsEnum::SCARE_GAS => WeaponsEnum::SCARE_GAS->value,
            WeaponsEnum::PHOTON_FLARES => WeaponsEnum::PHOTON_FLARES->value,
            WeaponsEnum::FRAG_GRENADE => WeaponsEnum::FRAG_GRENADE->value,
            WeaponsEnum::PLASMA_GRENADE => WeaponsEnum::PLASMA_GRENADE->value,
            WeaponsEnum::KRAK_GRENADE => WeaponsEnum::KRAK_GRENADE->value,
            WeaponsEnum::MELTA_BOMBS => WeaponsEnum::MELTA_BOMBS->value,
            WeaponsEnum::HALLUCINOGEN_GAS => WeaponsEnum::HALLUCINOGEN_GAS->value,
            WeaponsEnum::FLARE_ROCKET => WeaponsEnum::FLARE_ROCKET->value,
            // Special Ammunitions
            WeaponsEnum::BOLT_SHELLS => WeaponsEnum::BOLT_SHELLS->value,
            WeaponsEnum::DUM_DUM_BULLETS => WeaponsEnum::DUM_DUM_BULLETS->value,
            WeaponsEnum::HOT_SHOT_SHELLS => WeaponsEnum::HOT_SHOT_SHELLS->value,
            WeaponsEnum::MANSTOPPER_SHELLS => WeaponsEnum::MANSTOPPER_SHELLS->value,
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => WeaponsEnum::MISSILE_LAUNCHER_FRAG->value,
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => WeaponsEnum::MISSILE_LAUNCHER_KRAK->value,
            // Enfoncers
            WeaponsEnum::COMBAT_RIFLE => WeaponsEnum::COMBAT_RIFLE->value,
            WeaponsEnum::EXECUTIONER_SHELLS => WeaponsEnum::EXECUTIONER_SHELLS->value,
            WeaponsEnum::SUPPRESSIVE_SHIELD => WeaponsEnum::SUPPRESSIVE_SHIELD->value,
            WeaponsEnum::WEB_LAUNCHER => WeaponsEnum::WEB_LAUNCHER->value,
        };
    }

    function getWeaponType(): string
    {
        return match ($this) {
            // Pistols
            WeaponsEnum::STUB_GUN => self::PISTOLS,
            WeaponsEnum::AUTOPISTOL => self::PISTOLS,
            WeaponsEnum::LASPISTOL => self::PISTOLS,
            WeaponsEnum::HAND_FLAMER => self::PISTOLS,
            WeaponsEnum::BOLT_PISTOL => self::PISTOLS,
            WeaponsEnum::PLASMA_PISTOL => self::PISTOLS,
            WeaponsEnum::NEEDLE_PISTOL => self::PISTOLS,
            WeaponsEnum::WEB_PISTOL => self::PISTOLS,
            // Basic Weapons
            WeaponsEnum::AUTOGUN => self::BASIC_WEAPONS,
            WeaponsEnum::SHOTGUN_SOLID_SLUG => self::BASIC_WEAPONS,
            WeaponsEnum::SHOTGUN_SCATTER_SHOT => self::BASIC_WEAPONS,
            WeaponsEnum::SHOTGUN_MANSTOPPER => self::BASIC_WEAPONS,
            WeaponsEnum::SHOTGUN_HOT_SHOT => self::BASIC_WEAPONS,
            WeaponsEnum::SHOTGUN_BOLT => self::BASIC_WEAPONS,
            WeaponsEnum::HUNTING_RIFLE => self::BASIC_WEAPONS,
            WeaponsEnum::LASGUN => self::BASIC_WEAPONS,
            WeaponsEnum::BOLTGUN => self::BASIC_WEAPONS,
            // Special Weapons
            WeaponsEnum::AUTOSLUGGER => self::SPECIAL_WEAPONS,
            WeaponsEnum::FLAMER => self::SPECIAL_WEAPONS,
            WeaponsEnum::GRENADE_LAUNCHER => self::SPECIAL_WEAPONS,
            WeaponsEnum::PLASMA_GUN => self::SPECIAL_WEAPONS,
            WeaponsEnum::MELTAGUN => self::SPECIAL_WEAPONS,
            WeaponsEnum::NEEDLE_RIFLE => self::SPECIAL_WEAPONS,
            // Heavy Weapons
            WeaponsEnum::HEAVY_FLAMER => self::HEAVY_WEAPONS,
            WeaponsEnum::HEAVY_STUBBER => self::HEAVY_WEAPONS,
            WeaponsEnum::HEAVY_BOLTER => self::HEAVY_WEAPONS,
            WeaponsEnum::MISSILE_LAUNCHER => self::HEAVY_WEAPONS,
            WeaponsEnum::HEAVY_PLASMA_GUN => self::HEAVY_WEAPONS,
            WeaponsEnum::AUTOCANNON => self::HEAVY_WEAPONS,
            WeaponsEnum::LASCANNON => self::HEAVY_WEAPONS,
            // Hand-to-Hand Weapons
            WeaponsEnum::KNIFE => self::HAND_TO_HANDS_WEAPONS,
            WeaponsEnum::CHAIN_FLAIL => self::HAND_TO_HANDS_WEAPONS,
            WeaponsEnum::CLUB_MAUL_BLUDGEON => self::HAND_TO_HANDS_WEAPONS,
            WeaponsEnum::MASSIVE_WEAPON => self::HAND_TO_HANDS_WEAPONS,
            WeaponsEnum::SWORD => self::HAND_TO_HANDS_WEAPONS,
            WeaponsEnum::CHAIN_SWORD => self::HAND_TO_HANDS_WEAPONS,
            WeaponsEnum::POWER_AXE => self::HAND_TO_HANDS_WEAPONS,
            WeaponsEnum::SHOCK_MAUL => self::HAND_TO_HANDS_WEAPONS,
            WeaponsEnum::POWER_SWORD => self::HAND_TO_HANDS_WEAPONS,
            WeaponsEnum::POWER_FIST => self::HAND_TO_HANDS_WEAPONS,
            // Grenades
            WeaponsEnum::SMOKE_BOMBS => self::GRENADES,
            WeaponsEnum::CHOKE_GAS => self::GRENADES,
            WeaponsEnum::SCARE_GAS => self::GRENADES,
            WeaponsEnum::PHOTON_FLARES => self::GRENADES,
            WeaponsEnum::FRAG_GRENADE => self::GRENADES,
            WeaponsEnum::PLASMA_GRENADE => self::GRENADES,
            WeaponsEnum::KRAK_GRENADE => self::GRENADES,
            WeaponsEnum::MELTA_BOMBS => self::GRENADES,
            WeaponsEnum::HALLUCINOGEN_GAS => self::GRENADES,
            WeaponsEnum::FLARE_ROCKET => self::GRENADES,
            // Special Ammunitions
            WeaponsEnum::BOLT_SHELLS => self::SPECIAL_AMNUMITIONS,
            WeaponsEnum::DUM_DUM_BULLETS => self::SPECIAL_AMNUMITIONS,
            WeaponsEnum::HOT_SHOT_SHELLS => self::SPECIAL_AMNUMITIONS,
            WeaponsEnum::MANSTOPPER_SHELLS => self::SPECIAL_AMNUMITIONS,
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => self::SPECIAL_AMNUMITIONS,
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => self::SPECIAL_AMNUMITIONS,
            // Enfoncers
            WeaponsEnum::COMBAT_RIFLE => self::ENFONCERS,
            WeaponsEnum::EXECUTIONER_SHELLS => self::ENFONCERS,
            WeaponsEnum::SUPPRESSIVE_SHIELD => self::ENFONCERS,
            WeaponsEnum::WEB_LAUNCHER => self::ENFONCERS,
        };
    }

    function getFixedCost(): int
    {
        return match ($this) {
            // Pistols
            WeaponsEnum::STUB_GUN => 10,
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
            WeaponsEnum::MISSILE_LAUNCHER => 140,
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
            WeaponsEnum::FLARE_ROCKET => 10,
            // Special Ammunitions
            WeaponsEnum::BOLT_SHELLS => 15,
            WeaponsEnum::DUM_DUM_BULLETS => 5,
            WeaponsEnum::HOT_SHOT_SHELLS => 5,
            WeaponsEnum::MANSTOPPER_SHELLS => 5,
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => 35,
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => 50,
            // Enfoncers
            WeaponsEnum::COMBAT_RIFLE => 0,
            WeaponsEnum::EXECUTIONER_SHELLS => 0,
            WeaponsEnum::SUPPRESSIVE_SHIELD => 0,
            WeaponsEnum::WEB_LAUNCHER => 0,
        };
    }

    function getVariableDicesNumber(): int
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
            WeaponsEnum::MISSILE_LAUNCHER => 0,
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
            WeaponsEnum::FLARE_ROCKET => 0,
            // Special Ammunitions
            WeaponsEnum::BOLT_SHELLS => 0,
            WeaponsEnum::DUM_DUM_BULLETS => 0,
            WeaponsEnum::HOT_SHOT_SHELLS => 0,
            WeaponsEnum::MANSTOPPER_SHELLS => 0,
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => 0,
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => 0,
            // Enfoncers
            WeaponsEnum::COMBAT_RIFLE => 0,
            WeaponsEnum::EXECUTIONER_SHELLS => 0,
            WeaponsEnum::SUPPRESSIVE_SHIELD => 0,
            WeaponsEnum::WEB_LAUNCHER => 0,
        };
    }
    function getShortRange(): string
    {
        return match ($this) {
            // Pistols
            WeaponsEnum::STUB_GUN => '0-8',
            WeaponsEnum::AUTOPISTOL => '0-8',
            WeaponsEnum::LASPISTOL => '0-8',
            WeaponsEnum::HAND_FLAMER => ' - ',
            WeaponsEnum::BOLT_PISTOL => '0-8',
            WeaponsEnum::PLASMA_PISTOL => '0-8',
            WeaponsEnum::NEEDLE_PISTOL => '0-8',
            WeaponsEnum::WEB_PISTOL => '0-6',
            // Basic Weapons
            WeaponsEnum::AUTOGUN => '0-12',
            WeaponsEnum::SHOTGUN_SOLID_SLUG => '0-4',
            WeaponsEnum::SHOTGUN_SCATTER_SHOT => '0-4',
            WeaponsEnum::SHOTGUN_MANSTOPPER => '0-4',
            WeaponsEnum::SHOTGUN_HOT_SHOT => '0-4',
            WeaponsEnum::SHOTGUN_BOLT => '0-4',
            WeaponsEnum::HUNTING_RIFLE => '0-8',
            WeaponsEnum::LASGUN => '0-8',
            WeaponsEnum::BOLTGUN => '0-12',
            // Special Weapons
            WeaponsEnum::AUTOSLUGGER => '0-12',
            WeaponsEnum::FLAMER => ' - ',
            WeaponsEnum::GRENADE_LAUNCHER => '0-14',
            WeaponsEnum::PLASMA_GUN => '0-8',
            WeaponsEnum::MELTAGUN => '0-6',
            WeaponsEnum::NEEDLE_RIFLE => '0-16',
            // Heavy Weapons
            WeaponsEnum::HEAVY_FLAMER => ' - ',
            WeaponsEnum::HEAVY_STUBBER => '0-20',
            WeaponsEnum::HEAVY_BOLTER => '0-20',
            WeaponsEnum::MISSILE_LAUNCHER => ' - ',
            WeaponsEnum::HEAVY_PLASMA_GUN => '0-20',
            WeaponsEnum::AUTOCANNON => '0-20',
            WeaponsEnum::LASCANNON => '0-20',
            // Hand-to-Hand Weapons
            WeaponsEnum::KNIFE => ' - ',
            WeaponsEnum::CHAIN_FLAIL => ' - ',
            WeaponsEnum::CLUB_MAUL_BLUDGEON => ' - ',
            WeaponsEnum::MASSIVE_WEAPON => ' - ',
            WeaponsEnum::SWORD => ' - ',
            WeaponsEnum::CHAIN_SWORD => ' - ',
            WeaponsEnum::POWER_AXE => ' - ',
            WeaponsEnum::SHOCK_MAUL => ' - ',
            WeaponsEnum::POWER_SWORD => ' - ',
            WeaponsEnum::POWER_FIST => ' - ',
            // Grenades
            WeaponsEnum::SMOKE_BOMBS => ' - ',
            WeaponsEnum::CHOKE_GAS => ' - ',
            WeaponsEnum::SCARE_GAS => ' - ',
            WeaponsEnum::PHOTON_FLARES => ' - ',
            WeaponsEnum::FRAG_GRENADE => ' - ',
            WeaponsEnum::PLASMA_GRENADE => ' - ',
            WeaponsEnum::KRAK_GRENADE => ' - ',
            WeaponsEnum::MELTA_BOMBS => ' - ',
            WeaponsEnum::HALLUCINOGEN_GAS => ' - ',
            WeaponsEnum::FLARE_ROCKET => ' - ',
            // Special Ammunitions
            WeaponsEnum::BOLT_SHELLS => '0-4',
            WeaponsEnum::DUM_DUM_BULLETS => '0-8',
            WeaponsEnum::HOT_SHOT_SHELLS => '0-4',
            WeaponsEnum::MANSTOPPER_SHELLS => '0-4',
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => '0-20',
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => '0-20',
            // Enfoncers
            WeaponsEnum::COMBAT_RIFLE => '0-4',
            WeaponsEnum::EXECUTIONER_SHELLS => '0-4',
            WeaponsEnum::SUPPRESSIVE_SHIELD => ' - ',
            WeaponsEnum::WEB_LAUNCHER => '0-8',
        };
    }

    function getLongRange(): string
    {
        return match ($this) {
            // Pistols
            WeaponsEnum::STUB_GUN => '8-16',
            WeaponsEnum::AUTOPISTOL => '8-16',
            WeaponsEnum::LASPISTOL => '8-16',
            WeaponsEnum::HAND_FLAMER => ' - ',
            WeaponsEnum::BOLT_PISTOL => '8-16',
            WeaponsEnum::PLASMA_PISTOL => '8-16',
            WeaponsEnum::NEEDLE_PISTOL => '8-16',
            WeaponsEnum::WEB_PISTOL => '6-9',
            // Basic Weapons
            WeaponsEnum::AUTOGUN => '12-24',
            WeaponsEnum::SHOTGUN_SOLID_SLUG => '4-18',
            WeaponsEnum::SHOTGUN_SCATTER_SHOT => '4-18',
            WeaponsEnum::SHOTGUN_MANSTOPPER => '4-18',
            WeaponsEnum::SHOTGUN_HOT_SHOT => '4-18',
            WeaponsEnum::SHOTGUN_BOLT => '4-18',
            WeaponsEnum::HUNTING_RIFLE => '8-32',
            WeaponsEnum::LASGUN => '8-24',
            WeaponsEnum::BOLTGUN => '12-24',
            // Special Weapons
            WeaponsEnum::AUTOSLUGGER => '12-24',
            WeaponsEnum::FLAMER => ' - ',
            WeaponsEnum::GRENADE_LAUNCHER => '14-28',
            WeaponsEnum::PLASMA_GUN => '8-24',
            WeaponsEnum::MELTAGUN => '6-12',
            WeaponsEnum::NEEDLE_RIFLE => '16-32',
            // Heavy Weapons
            WeaponsEnum::HEAVY_FLAMER => ' - ',
            WeaponsEnum::HEAVY_STUBBER => '20-40',
            WeaponsEnum::HEAVY_BOLTER => '20-40',
            WeaponsEnum::MISSILE_LAUNCHER => '20-72',
            WeaponsEnum::HEAVY_PLASMA_GUN => '20-40',
            WeaponsEnum::AUTOCANNON => '20-72',
            WeaponsEnum::LASCANNON => '20-60',
            // Hand-to-Hand Weapons
            WeaponsEnum::KNIFE => ' - ',
            WeaponsEnum::CHAIN_FLAIL => ' - ',
            WeaponsEnum::CLUB_MAUL_BLUDGEON => ' - ',
            WeaponsEnum::MASSIVE_WEAPON => ' - ',
            WeaponsEnum::SWORD => ' - ',
            WeaponsEnum::CHAIN_SWORD => ' - ',
            WeaponsEnum::POWER_AXE => ' - ',
            WeaponsEnum::SHOCK_MAUL => ' - ',
            WeaponsEnum::POWER_SWORD => ' - ',
            WeaponsEnum::POWER_FIST => ' - ',
            // Grenades
            WeaponsEnum::SMOKE_BOMBS => ' - ',
            WeaponsEnum::CHOKE_GAS => ' - ',
            WeaponsEnum::SCARE_GAS => ' - ',
            WeaponsEnum::PHOTON_FLARES => ' - ',
            WeaponsEnum::FRAG_GRENADE => ' - ',
            WeaponsEnum::PLASMA_GRENADE => ' - ',
            WeaponsEnum::KRAK_GRENADE => ' - ',
            WeaponsEnum::MELTA_BOMBS => ' - ',
            WeaponsEnum::HALLUCINOGEN_GAS => ' - ',
            WeaponsEnum::FLARE_ROCKET => ' - ',
            // Special Ammunitions
            WeaponsEnum::BOLT_SHELLS => '4-24',
            WeaponsEnum::DUM_DUM_BULLETS => '8-16',
            WeaponsEnum::HOT_SHOT_SHELLS => '4-18',
            WeaponsEnum::MANSTOPPER_SHELLS => '4-18',
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => '20-72',
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => '20-72',
            // Enfoncers
            WeaponsEnum::COMBAT_RIFLE => '4-18',
            WeaponsEnum::EXECUTIONER_SHELLS => '4-18',
            WeaponsEnum::SUPPRESSIVE_SHIELD => ' - ',
            WeaponsEnum::WEB_LAUNCHER => '8-12',
        };
    }

    function getBonusToHitShort(): string
    {
        return match ($this) {
            // Pistols
            WeaponsEnum::STUB_GUN => '+1',
            WeaponsEnum::AUTOPISTOL => '+2',
            WeaponsEnum::LASPISTOL => '+1',
            WeaponsEnum::HAND_FLAMER => ' - ',
            WeaponsEnum::BOLT_PISTOL => '+2',
            WeaponsEnum::PLASMA_PISTOL => '+1',
            WeaponsEnum::NEEDLE_PISTOL => '+2',
            WeaponsEnum::WEB_PISTOL => ' - ',
            // Basic Weapons
            WeaponsEnum::AUTOGUN => '+1',
            WeaponsEnum::SHOTGUN_SOLID_SLUG => '+1',
            WeaponsEnum::SHOTGUN_SCATTER_SHOT => '+1',
            WeaponsEnum::SHOTGUN_MANSTOPPER => '+1',
            WeaponsEnum::SHOTGUN_HOT_SHOT => '+1',
            WeaponsEnum::SHOTGUN_BOLT => '+1',
            WeaponsEnum::HUNTING_RIFLE => '-1',
            WeaponsEnum::LASGUN => '+1',
            WeaponsEnum::BOLTGUN => '+1',
            // Special Weapons
            WeaponsEnum::AUTOSLUGGER => '+1',
            WeaponsEnum::FLAMER => ' - ',
            WeaponsEnum::GRENADE_LAUNCHER => ' - ',
            WeaponsEnum::PLASMA_GUN => '+1',
            WeaponsEnum::MELTAGUN => '+1',
            WeaponsEnum::NEEDLE_RIFLE => '+1',
            // Heavy Weapons
            WeaponsEnum::HEAVY_FLAMER => ' - ',
            WeaponsEnum::HEAVY_STUBBER => ' - ',
            WeaponsEnum::HEAVY_BOLTER => ' - ',
            WeaponsEnum::MISSILE_LAUNCHER => ' - ',
            WeaponsEnum::HEAVY_PLASMA_GUN => ' - ',
            WeaponsEnum::AUTOCANNON => ' - ',
            WeaponsEnum::LASCANNON => ' - ',
            // Hand-to-Hand Weapons
            WeaponsEnum::KNIFE => ' - ',
            WeaponsEnum::CHAIN_FLAIL => ' - ',
            WeaponsEnum::CLUB_MAUL_BLUDGEON => ' - ',
            WeaponsEnum::MASSIVE_WEAPON => ' - ',
            WeaponsEnum::SWORD => ' - ',
            WeaponsEnum::CHAIN_SWORD => ' - ',
            WeaponsEnum::POWER_AXE => ' - ',
            WeaponsEnum::SHOCK_MAUL => ' - ',
            WeaponsEnum::POWER_SWORD => ' - ',
            WeaponsEnum::POWER_FIST => ' - ',
            // Grenades
            WeaponsEnum::SMOKE_BOMBS => ' - ',
            WeaponsEnum::CHOKE_GAS => ' - ',
            WeaponsEnum::SCARE_GAS => ' - ',
            WeaponsEnum::PHOTON_FLARES => ' - ',
            WeaponsEnum::FRAG_GRENADE => ' - ',
            WeaponsEnum::PLASMA_GRENADE => ' - ',
            WeaponsEnum::KRAK_GRENADE => ' - ',
            WeaponsEnum::MELTA_BOMBS => ' - ',
            WeaponsEnum::HALLUCINOGEN_GAS => ' - ',
            WeaponsEnum::FLARE_ROCKET => ' - ',
            // Special Ammunitions
            WeaponsEnum::BOLT_SHELLS => '+1',
            WeaponsEnum::DUM_DUM_BULLETS => '+1',
            WeaponsEnum::HOT_SHOT_SHELLS => '+1',
            WeaponsEnum::MANSTOPPER_SHELLS => '+1',
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => ' - ',
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => ' - ',
            // Enfoncers
            WeaponsEnum::COMBAT_RIFLE => '+1',
            WeaponsEnum::EXECUTIONER_SHELLS => '_1',
            WeaponsEnum::SUPPRESSIVE_SHIELD => ' - ',
            WeaponsEnum::WEB_LAUNCHER => ' - ',
        };
    }
    function getBonusToHitLong(): string
    {
        return match ($this) {
            // Pistols
            WeaponsEnum::STUB_GUN => ' - ',
            WeaponsEnum::AUTOPISTOL => ' - ',
            WeaponsEnum::LASPISTOL => ' - ',
            WeaponsEnum::HAND_FLAMER => ' - ',
            WeaponsEnum::BOLT_PISTOL => ' - ',
            WeaponsEnum::PLASMA_PISTOL => ' - ',
            WeaponsEnum::NEEDLE_PISTOL => ' - ',
            WeaponsEnum::WEB_PISTOL => '-1',
            // Basic Weapons
            WeaponsEnum::AUTOGUN => ' - ',
            WeaponsEnum::SHOTGUN_SOLID_SLUG => '-1',
            WeaponsEnum::SHOTGUN_SCATTER_SHOT => '-1',
            WeaponsEnum::SHOTGUN_MANSTOPPER => ' - ',
            WeaponsEnum::SHOTGUN_HOT_SHOT => '-1',
            WeaponsEnum::SHOTGUN_BOLT => ' - ',
            WeaponsEnum::HUNTING_RIFLE => ' - ',
            WeaponsEnum::LASGUN => ' - ',
            WeaponsEnum::BOLTGUN => ' - ',
            // Special Weapons
            WeaponsEnum::AUTOSLUGGER => ' - ',
            WeaponsEnum::FLAMER => ' - ',
            WeaponsEnum::GRENADE_LAUNCHER => '-1',
            WeaponsEnum::PLASMA_GUN => ' - ',
            WeaponsEnum::MELTAGUN => ' - ',
            WeaponsEnum::NEEDLE_RIFLE => ' - ',
            // Heavy Weapons
            WeaponsEnum::HEAVY_FLAMER => ' - ',
            WeaponsEnum::HEAVY_STUBBER => ' - ',
            WeaponsEnum::HEAVY_BOLTER => ' - ',
            WeaponsEnum::MISSILE_LAUNCHER => ' - ',
            WeaponsEnum::HEAVY_PLASMA_GUN => ' - ',
            WeaponsEnum::AUTOCANNON => ' - ',
            WeaponsEnum::LASCANNON => ' - ',
            // Hand-to-Hand Weapons
            WeaponsEnum::KNIFE => ' - ',
            WeaponsEnum::CHAIN_FLAIL => ' - ',
            WeaponsEnum::CLUB_MAUL_BLUDGEON => ' - ',
            WeaponsEnum::MASSIVE_WEAPON => ' - ',
            WeaponsEnum::SWORD => ' - ',
            WeaponsEnum::CHAIN_SWORD => ' - ',
            WeaponsEnum::POWER_AXE => ' - ',
            WeaponsEnum::SHOCK_MAUL => ' - ',
            WeaponsEnum::POWER_SWORD => ' - ',
            WeaponsEnum::POWER_FIST => ' - ',
            // Grenades
            WeaponsEnum::SMOKE_BOMBS => ' - ',
            WeaponsEnum::CHOKE_GAS => ' - ',
            WeaponsEnum::SCARE_GAS => ' - ',
            WeaponsEnum::PHOTON_FLARES => ' - ',
            WeaponsEnum::FRAG_GRENADE => ' - ',
            WeaponsEnum::PLASMA_GRENADE => ' - ',
            WeaponsEnum::KRAK_GRENADE => ' - ',
            WeaponsEnum::MELTA_BOMBS => ' - ',
            WeaponsEnum::HALLUCINOGEN_GAS => ' - ',
            WeaponsEnum::FLARE_ROCKET => ' - ',
            // Special Ammunitions
            WeaponsEnum::BOLT_SHELLS => ' - ',
            WeaponsEnum::DUM_DUM_BULLETS => ' - ',
            WeaponsEnum::HOT_SHOT_SHELLS => '-1',
            WeaponsEnum::MANSTOPPER_SHELLS => ' - ',
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => ' - ',
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => ' - ',
            // Enfoncers
            WeaponsEnum::COMBAT_RIFLE => '-1',
            WeaponsEnum::EXECUTIONER_SHELLS => '+1',
            WeaponsEnum::SUPPRESSIVE_SHIELD => ' - ',
            WeaponsEnum::WEB_LAUNCHER => '-1',
        };
    }

    function getStrength(): string
    {
        return match ($this) {
            // Pistols
            WeaponsEnum::STUB_GUN => '3',
            WeaponsEnum::AUTOPISTOL => '3',
            WeaponsEnum::LASPISTOL => '3',
            WeaponsEnum::HAND_FLAMER => '3',
            WeaponsEnum::BOLT_PISTOL => '4',
            WeaponsEnum::PLASMA_PISTOL => '4',
            WeaponsEnum::NEEDLE_PISTOL => '3',
            WeaponsEnum::WEB_PISTOL => ' - ',
            // Basic Weapons
            WeaponsEnum::AUTOGUN => '3',
            WeaponsEnum::SHOTGUN_SOLID_SLUG => '4',
            WeaponsEnum::SHOTGUN_SCATTER_SHOT => '3',
            WeaponsEnum::SHOTGUN_MANSTOPPER => '4',
            WeaponsEnum::SHOTGUN_HOT_SHOT => '4',
            WeaponsEnum::SHOTGUN_BOLT => '4',
            WeaponsEnum::HUNTING_RIFLE => '3',
            WeaponsEnum::LASGUN => '3',
            WeaponsEnum::BOLTGUN => '4',
            // Special Weapons
            WeaponsEnum::AUTOSLUGGER => '3',
            WeaponsEnum::FLAMER => '4',
            WeaponsEnum::GRENADE_LAUNCHER => ' - ',
            WeaponsEnum::PLASMA_GUN => '5',
            WeaponsEnum::MELTAGUN => '8',
            WeaponsEnum::NEEDLE_RIFLE => '3',
            // Heavy Weapons
            WeaponsEnum::HEAVY_FLAMER => '5',
            WeaponsEnum::HEAVY_STUBBER => '4',
            WeaponsEnum::HEAVY_BOLTER => '5',
            WeaponsEnum::MISSILE_LAUNCHER => '4',
            WeaponsEnum::HEAVY_PLASMA_GUN => '7',
            WeaponsEnum::AUTOCANNON => '8',
            WeaponsEnum::LASCANNON => '9',
            // Hand-to-Hand Weapons
            WeaponsEnum::KNIFE => 'user',
            WeaponsEnum::CHAIN_FLAIL => 'user+1',
            WeaponsEnum::CLUB_MAUL_BLUDGEON => 'user+1',
            WeaponsEnum::MASSIVE_WEAPON => 'user+2',
            WeaponsEnum::SWORD => 'user',
            WeaponsEnum::CHAIN_SWORD => '4',
            WeaponsEnum::POWER_AXE => 'user+3',
            WeaponsEnum::SHOCK_MAUL => '5',
            WeaponsEnum::POWER_SWORD => 'user+2',
            WeaponsEnum::POWER_FIST => 'user+5',
            // Grenades
            WeaponsEnum::SMOKE_BOMBS => ' - ',
            WeaponsEnum::CHOKE_GAS => ' - ',
            WeaponsEnum::SCARE_GAS => ' - ',
            WeaponsEnum::PHOTON_FLARES => ' - ',
            WeaponsEnum::FRAG_GRENADE => '3',
            WeaponsEnum::PLASMA_GRENADE => '5',
            WeaponsEnum::KRAK_GRENADE => '6',
            WeaponsEnum::MELTA_BOMBS => '8',
            WeaponsEnum::HALLUCINOGEN_GAS => ' - ',
            WeaponsEnum::FLARE_ROCKET => ' - ',
            // Special Ammunitions
            WeaponsEnum::BOLT_SHELLS => '4',
            WeaponsEnum::DUM_DUM_BULLETS => '4',
            WeaponsEnum::HOT_SHOT_SHELLS => '4',
            WeaponsEnum::MANSTOPPER_SHELLS => '4',
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => '4',
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => '8',
            // Enfoncers
            WeaponsEnum::COMBAT_RIFLE => '4',
            WeaponsEnum::EXECUTIONER_SHELLS => '4',
            WeaponsEnum::SUPPRESSIVE_SHIELD => '3',
            WeaponsEnum::WEB_LAUNCHER => ' - ',
        };
    }

    function getDamage(): string
    {
        return match ($this) {
            // Pistols
            WeaponsEnum::STUB_GUN => '1',
            WeaponsEnum::AUTOPISTOL => '1',
            WeaponsEnum::LASPISTOL => '1',
            WeaponsEnum::HAND_FLAMER => '1',
            WeaponsEnum::BOLT_PISTOL => '1',
            WeaponsEnum::PLASMA_PISTOL => '1',
            WeaponsEnum::NEEDLE_PISTOL => '1',
            WeaponsEnum::WEB_PISTOL => ' - ',
            // Basic Weapons
            WeaponsEnum::AUTOGUN => '1',
            WeaponsEnum::SHOTGUN_SOLID_SLUG => '1',
            WeaponsEnum::SHOTGUN_SCATTER_SHOT => '1',
            WeaponsEnum::SHOTGUN_MANSTOPPER => '1',
            WeaponsEnum::SHOTGUN_HOT_SHOT => '1',
            WeaponsEnum::SHOTGUN_BOLT => '1',
            WeaponsEnum::HUNTING_RIFLE => '1',
            WeaponsEnum::LASGUN => '1',
            WeaponsEnum::BOLTGUN => '1',
            // Special Weapons
            WeaponsEnum::AUTOSLUGGER => '1',
            WeaponsEnum::FLAMER => '1',
            WeaponsEnum::GRENADE_LAUNCHER => ' - ',
            WeaponsEnum::PLASMA_GUN => '1',
            WeaponsEnum::MELTAGUN => 'D6',
            WeaponsEnum::NEEDLE_RIFLE => '1',
            // Heavy Weapons
            WeaponsEnum::HEAVY_FLAMER => 'D3',
            WeaponsEnum::HEAVY_STUBBER => '1',
            WeaponsEnum::HEAVY_BOLTER => 'D3',
            WeaponsEnum::MISSILE_LAUNCHER => '1',
            WeaponsEnum::HEAVY_PLASMA_GUN => 'D3',
            WeaponsEnum::AUTOCANNON => 'D6',
            WeaponsEnum::LASCANNON => '2D6',
            // Hand-to-Hand Weapons
            WeaponsEnum::KNIFE => '1',
            WeaponsEnum::CHAIN_FLAIL => '1',
            WeaponsEnum::CLUB_MAUL_BLUDGEON => '1',
            WeaponsEnum::MASSIVE_WEAPON => '1',
            WeaponsEnum::SWORD => '1',
            WeaponsEnum::CHAIN_SWORD => '1',
            WeaponsEnum::POWER_AXE => '1',
            WeaponsEnum::SHOCK_MAUL => '1',
            WeaponsEnum::POWER_SWORD => '1',
            WeaponsEnum::POWER_FIST => 'D3',
            // Grenades
            WeaponsEnum::SMOKE_BOMBS => ' - ',
            WeaponsEnum::CHOKE_GAS => ' - ',
            WeaponsEnum::SCARE_GAS => ' - ',
            WeaponsEnum::PHOTON_FLARES => ' - ',
            WeaponsEnum::FRAG_GRENADE => '1',
            WeaponsEnum::PLASMA_GRENADE => '1',
            WeaponsEnum::KRAK_GRENADE => 'D6',
            WeaponsEnum::MELTA_BOMBS => '2D6',
            WeaponsEnum::HALLUCINOGEN_GAS => ' - ',
            WeaponsEnum::FLARE_ROCKET => ' - ',
            // Special Ammunitions
            WeaponsEnum::BOLT_SHELLS => '1',
            WeaponsEnum::DUM_DUM_BULLETS => '1',
            WeaponsEnum::HOT_SHOT_SHELLS => '1',
            WeaponsEnum::MANSTOPPER_SHELLS => '1',
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => '1',
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => 'D6',
            // Enfoncers
            WeaponsEnum::COMBAT_RIFLE => '1',
            WeaponsEnum::EXECUTIONER_SHELLS => '1',
            WeaponsEnum::SUPPRESSIVE_SHIELD => '1',
            WeaponsEnum::WEB_LAUNCHER => ' - ',
        };
    }

    function getSaveModifier(): string
    {
        return match ($this) {
            // Pistols
            WeaponsEnum::STUB_GUN => ' - ',
            WeaponsEnum::AUTOPISTOL => ' - ',
            WeaponsEnum::LASPISTOL => ' - ',
            WeaponsEnum::HAND_FLAMER => '-1',
            WeaponsEnum::BOLT_PISTOL => '-1',
            WeaponsEnum::PLASMA_PISTOL => '-1',
            WeaponsEnum::NEEDLE_PISTOL => '-1',
            WeaponsEnum::WEB_PISTOL => ' - ',
            // Basic Weapons
            WeaponsEnum::AUTOGUN => ' - ',
            WeaponsEnum::SHOTGUN_SOLID_SLUG => ' - ',
            WeaponsEnum::SHOTGUN_SCATTER_SHOT => ' - ',
            WeaponsEnum::SHOTGUN_MANSTOPPER => ' - ',
            WeaponsEnum::SHOTGUN_HOT_SHOT => ' - ',
            WeaponsEnum::SHOTGUN_BOLT => '-1',
            WeaponsEnum::HUNTING_RIFLE => ' - ',
            WeaponsEnum::LASGUN => ' - ',
            WeaponsEnum::BOLTGUN => '-1',
            // Special Weapons
            WeaponsEnum::AUTOSLUGGER => ' - ',
            WeaponsEnum::FLAMER => '-2',
            WeaponsEnum::GRENADE_LAUNCHER => ' - ',
            WeaponsEnum::PLASMA_GUN => '-2',
            WeaponsEnum::MELTAGUN => '-5',
            WeaponsEnum::NEEDLE_RIFLE => '-1',
            // Heavy Weapons
            WeaponsEnum::HEAVY_FLAMER => '-3',
            WeaponsEnum::HEAVY_STUBBER => '-1',
            WeaponsEnum::HEAVY_BOLTER => '-2',
            WeaponsEnum::MISSILE_LAUNCHER => '-2',
            WeaponsEnum::HEAVY_PLASMA_GUN => '-4',
            WeaponsEnum::AUTOCANNON => '-5',
            WeaponsEnum::LASCANNON => '-6',
            // Hand-to-Hand Weapons
            WeaponsEnum::KNIFE => ' - ',
            WeaponsEnum::CHAIN_FLAIL => ' - ',
            WeaponsEnum::CLUB_MAUL_BLUDGEON => ' - ',
            WeaponsEnum::MASSIVE_WEAPON => ' - ',
            WeaponsEnum::SWORD => ' - ',
            WeaponsEnum::CHAIN_SWORD => '-2',
            WeaponsEnum::POWER_AXE => ' - ',
            WeaponsEnum::SHOCK_MAUL => '-2',
            WeaponsEnum::POWER_SWORD => ' - ',
            WeaponsEnum::POWER_FIST => ' - ',
            // Grenades
            WeaponsEnum::SMOKE_BOMBS => ' - ',
            WeaponsEnum::CHOKE_GAS => ' - ',
            WeaponsEnum::SCARE_GAS => ' - ',
            WeaponsEnum::PHOTON_FLARES => ' - ',
            WeaponsEnum::FRAG_GRENADE => '-1',
            WeaponsEnum::PLASMA_GRENADE => '-2',
            WeaponsEnum::KRAK_GRENADE => '-3',
            WeaponsEnum::MELTA_BOMBS => '-5',
            WeaponsEnum::HALLUCINOGEN_GAS => ' - ',
            WeaponsEnum::FLARE_ROCKET => ' - ',
            // Special Ammunitions
            WeaponsEnum::BOLT_SHELLS => '-1',
            WeaponsEnum::DUM_DUM_BULLETS => ' - ',
            WeaponsEnum::HOT_SHOT_SHELLS => ' - ',
            WeaponsEnum::MANSTOPPER_SHELLS => ' - ',
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => '-2',
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => '-5',
            // Enfoncers
            WeaponsEnum::COMBAT_RIFLE => ' - ',
            WeaponsEnum::EXECUTIONER_SHELLS => '-2',
            WeaponsEnum::SUPPRESSIVE_SHIELD => '-1',
            WeaponsEnum::WEB_LAUNCHER => ' - ',
        };
    }

    function getAmmoRoll(): string
    {
        return match ($this) {
            // Pistols
            WeaponsEnum::STUB_GUN => '4+',
            WeaponsEnum::AUTOPISTOL => '4+',
            WeaponsEnum::LASPISTOL => '2+',
            WeaponsEnum::HAND_FLAMER => '5+',
            WeaponsEnum::BOLT_PISTOL => '6+',
            WeaponsEnum::PLASMA_PISTOL => '4+',
            WeaponsEnum::NEEDLE_PISTOL => '6+',
            WeaponsEnum::WEB_PISTOL => '6+',
            // Basic Weapons
            WeaponsEnum::AUTOGUN => '4+',
            WeaponsEnum::SHOTGUN_SOLID_SLUG => '4+',
            WeaponsEnum::SHOTGUN_SCATTER_SHOT => '4+',
            WeaponsEnum::SHOTGUN_MANSTOPPER => '4+',
            WeaponsEnum::SHOTGUN_HOT_SHOT => '6+',
            WeaponsEnum::SHOTGUN_BOLT => '6+',
            WeaponsEnum::HUNTING_RIFLE => '4+',
            WeaponsEnum::LASGUN => '2+',
            WeaponsEnum::BOLTGUN => '6+',
            // Special Weapons
            WeaponsEnum::AUTOSLUGGER => '5+',
            WeaponsEnum::FLAMER => '4+',
            WeaponsEnum::GRENADE_LAUNCHER => '6+',
            WeaponsEnum::PLASMA_GUN => '4+',
            WeaponsEnum::MELTAGUN => '4+',
            WeaponsEnum::NEEDLE_RIFLE => '6+',
            // Heavy Weapons
            WeaponsEnum::HEAVY_FLAMER => '3+',
            WeaponsEnum::HEAVY_STUBBER => '4+',
            WeaponsEnum::HEAVY_BOLTER => '6+',
            WeaponsEnum::MISSILE_LAUNCHER => '6+',
            WeaponsEnum::HEAVY_PLASMA_GUN => '4+',
            WeaponsEnum::AUTOCANNON => '4+',
            WeaponsEnum::LASCANNON => '2+',
            // Hand-to-Hand Weapons
            WeaponsEnum::KNIFE => ' - ',
            WeaponsEnum::CHAIN_FLAIL => ' - ',
            WeaponsEnum::CLUB_MAUL_BLUDGEON => ' - ',
            WeaponsEnum::MASSIVE_WEAPON => ' - ',
            WeaponsEnum::SWORD => ' - ',
            WeaponsEnum::CHAIN_SWORD => ' - ',
            WeaponsEnum::POWER_AXE => ' - ',
            WeaponsEnum::SHOCK_MAUL =>' - ',
            WeaponsEnum::POWER_SWORD => ' - ',
            WeaponsEnum::POWER_FIST => ' - ',
            // Grenades
            WeaponsEnum::SMOKE_BOMBS => ' - ',
            WeaponsEnum::CHOKE_GAS => ' - ',
            WeaponsEnum::SCARE_GAS => ' - ',
            WeaponsEnum::PHOTON_FLARES => ' - ',
            WeaponsEnum::FRAG_GRENADE => ' - ',
            WeaponsEnum::PLASMA_GRENADE => ' - ',
            WeaponsEnum::KRAK_GRENADE => ' - ',
            WeaponsEnum::MELTA_BOMBS => ' - ',
            WeaponsEnum::HALLUCINOGEN_GAS => ' - ',
            WeaponsEnum::FLARE_ROCKET => ' - ',
            // Special Ammunitions
            WeaponsEnum::BOLT_SHELLS => '6+',
            WeaponsEnum::DUM_DUM_BULLETS => '4+',
            WeaponsEnum::HOT_SHOT_SHELLS => '4+',
            WeaponsEnum::MANSTOPPER_SHELLS => '4+',
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => '6+',
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => '6+',
            // Enfoncers
            WeaponsEnum::COMBAT_RIFLE => '4+',
            WeaponsEnum::EXECUTIONER_SHELLS => '6+',
            WeaponsEnum::SUPPRESSIVE_SHIELD => ' - ',
            WeaponsEnum::WEB_LAUNCHER => '5+',
        };
    }

    function getSpecial(): string
    {
        return match ($this) {
            // Pistols
            WeaponsEnum::STUB_GUN => ' - ',
            WeaponsEnum::AUTOPISTOL => ' - ',
            WeaponsEnum::LASPISTOL => ' - ',
            WeaponsEnum::HAND_FLAMER => 'Flamer, Ammo Roll, Catch Fire (5+)',
            WeaponsEnum::BOLT_PISTOL => ' - ',
            WeaponsEnum::PLASMA_PISTOL => ' - ',
            WeaponsEnum::NEEDLE_PISTOL => 'Toxic Dart, Injuries, Silent',
            WeaponsEnum::WEB_PISTOL => 'Webbed Targets, Solvent, Capture',
            // Basic Weapons
            WeaponsEnum::AUTOGUN => ' - ',
            WeaponsEnum::SHOTGUN_SOLID_SLUG => 'Knock-back',
            WeaponsEnum::SHOTGUN_SCATTER_SHOT => 'Saturation',
            WeaponsEnum::SHOTGUN_MANSTOPPER => 'Knock-back',
            WeaponsEnum::SHOTGUN_HOT_SHOT => 'Knock-back, Catch Fire (5+)',
            WeaponsEnum::SHOTGUN_BOLT => ' - ',
            WeaponsEnum::HUNTING_RIFLE => 'Critical Shot',
            WeaponsEnum::LASGUN => ' - ',
            WeaponsEnum::BOLTGUN => ' - ',
            // Special Weapons
            WeaponsEnum::AUTOSLUGGER => 'Sustained Fire (1)',
            WeaponsEnum::FLAMER => 'Flamer, Ammo Roll, Catch Fire (4+)',
            WeaponsEnum::GRENADE_LAUNCHER => 'Ammo',
            WeaponsEnum::PLASMA_GUN => ' - ',
            WeaponsEnum::MELTAGUN => 'High Impact',
            WeaponsEnum::NEEDLE_RIFLE => 'Toxic Dart, Injuries, Silent',
            // Heavy Weapons
            WeaponsEnum::HEAVY_FLAMER => 'Flamer, Ammo Roll, Catch Fire (3+), Move And Fire',
            WeaponsEnum::HEAVY_STUBBER => 'Sustained Fire (2)',
            WeaponsEnum::HEAVY_BOLTER => 'Sustained Fire (2)',
            WeaponsEnum::MISSILE_LAUNCHER => 'Gas Cloud',
            WeaponsEnum::HEAVY_PLASMA_GUN => 'Blast, High Impact',
            WeaponsEnum::AUTOCANNON => 'Sustained Fire (1), High Impact',
            WeaponsEnum::LASCANNON => 'High Impact, Terrifying Force',
            // Hand-to-Hand Weapons
            WeaponsEnum::KNIFE => ' - ',
            WeaponsEnum::CHAIN_FLAIL => 'Nullify, Clumsy',
            WeaponsEnum::CLUB_MAUL_BLUDGEON => ' - ',
            WeaponsEnum::MASSIVE_WEAPON => 'Two-handed, Draw, Mighty Blow',
            WeaponsEnum::SWORD => 'Parry',
            WeaponsEnum::CHAIN_SWORD => 'Parry, Noisy',
            WeaponsEnum::POWER_AXE => 'Dual-handed',
            WeaponsEnum::SHOCK_MAUL =>'Out of Action, Injury',
            WeaponsEnum::POWER_SWORD => 'Parry',
            WeaponsEnum::POWER_FIST => ' - ',
            // Grenades
            WeaponsEnum::SMOKE_BOMBS => 'Gas Cloud, Smoke',
            WeaponsEnum::CHOKE_GAS => 'Gas Cloud, Choke',
            WeaponsEnum::SCARE_GAS => 'Gas Cloud, Scare',
            WeaponsEnum::PHOTON_FLARES => 'Blast, Blind',
            WeaponsEnum::FRAG_GRENADE => 'Gas Cloud',
            WeaponsEnum::PLASMA_GRENADE => 'Blast, Plasma Ball',
            WeaponsEnum::KRAK_GRENADE => '-1 Hit, Demolition',
            WeaponsEnum::MELTA_BOMBS => 'Demolition',
            WeaponsEnum::HALLUCINOGEN_GAS => 'Gas Cloud, Hallucinogen',
            WeaponsEnum::FLARE_ROCKET => 'Flare',
            // Special Ammunitions
            WeaponsEnum::BOLT_SHELLS => ' - ',
            WeaponsEnum::DUM_DUM_BULLETS => 'Dum-dum Bullets',
            WeaponsEnum::HOT_SHOT_SHELLS => 'Knock-back, Catch Fire (5+)',
            WeaponsEnum::MANSTOPPER_SHELLS => 'Knock-back',
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => 'Gas cloud',
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => 'High Impact',
            // Enfoncers
            WeaponsEnum::COMBAT_RIFLE => ' - ',
            WeaponsEnum::EXECUTIONER_SHELLS => ' - ',
            WeaponsEnum::SUPPRESSIVE_SHIELD => 'Armor',
            WeaponsEnum::WEB_LAUNCHER => 'Webbed Targets, Solvent, Capture',
        };
    }

    function isCustomRules(): bool
    {
        return match ($this) {
            // Pistols
            WeaponsEnum::FLARE_ROCKET => true,
            // Enfoncers
            WeaponsEnum::SUPPRESSIVE_SHIELD => true,
        };
    }

    function isAvailableOnMenu(): bool
    {
        return match ($this) {
            // Pistols
            WeaponsEnum::STUB_GUN => true,
            WeaponsEnum::AUTOPISTOL => true,
            WeaponsEnum::LASPISTOL => true,
            WeaponsEnum::HAND_FLAMER => true,
            WeaponsEnum::BOLT_PISTOL => true,
            WeaponsEnum::PLASMA_PISTOL => true,
            WeaponsEnum::NEEDLE_PISTOL => true,
            WeaponsEnum::WEB_PISTOL => true,
            // Basic Weapons
            WeaponsEnum::AUTOGUN => true,
            WeaponsEnum::SHOTGUN_SOLID_SLUG => true,
            WeaponsEnum::SHOTGUN_SCATTER_SHOT => true,
            WeaponsEnum::SHOTGUN_MANSTOPPER => false,
            WeaponsEnum::SHOTGUN_HOT_SHOT => false,
            WeaponsEnum::SHOTGUN_BOLT => false,
            WeaponsEnum::HUNTING_RIFLE => true,
            WeaponsEnum::LASGUN => true,
            WeaponsEnum::BOLTGUN => true,
            // Special Weapons
            WeaponsEnum::AUTOSLUGGER => true,
            WeaponsEnum::FLAMER => true,
            WeaponsEnum::GRENADE_LAUNCHER => true,
            WeaponsEnum::PLASMA_GUN => true,
            WeaponsEnum::MELTAGUN => true,
            WeaponsEnum::NEEDLE_RIFLE => true,
            // Heavy Weapons
            WeaponsEnum::HEAVY_FLAMER => true,
            WeaponsEnum::HEAVY_STUBBER => true,
            WeaponsEnum::HEAVY_BOLTER => true,
            WeaponsEnum::MISSILE_LAUNCHER => true,
            WeaponsEnum::HEAVY_PLASMA_GUN => true,
            WeaponsEnum::AUTOCANNON => true,
            WeaponsEnum::LASCANNON => true,
            // Hand-to-Hand Weapons
            WeaponsEnum::KNIFE => true,
            WeaponsEnum::CHAIN_FLAIL => true,
            WeaponsEnum::CLUB_MAUL_BLUDGEON => true,
            WeaponsEnum::MASSIVE_WEAPON => true,
            WeaponsEnum::SWORD => true,
            WeaponsEnum::CHAIN_SWORD => true,
            WeaponsEnum::POWER_AXE => true,
            WeaponsEnum::SHOCK_MAUL => true,
            WeaponsEnum::POWER_SWORD => true,
            WeaponsEnum::POWER_FIST => true,
            // Grenades
            WeaponsEnum::SMOKE_BOMBS => true,
            WeaponsEnum::CHOKE_GAS => true,
            WeaponsEnum::SCARE_GAS => true,
            WeaponsEnum::PHOTON_FLARES => true,
            WeaponsEnum::FRAG_GRENADE => true,
            WeaponsEnum::PLASMA_GRENADE => true,
            WeaponsEnum::KRAK_GRENADE => true,
            WeaponsEnum::MELTA_BOMBS => true,
            WeaponsEnum::HALLUCINOGEN_GAS => true,
            WeaponsEnum::FLARE_ROCKET => true,
            // Special Ammunitions
            WeaponsEnum::BOLT_SHELLS => true,
            WeaponsEnum::DUM_DUM_BULLETS => true,
            WeaponsEnum::HOT_SHOT_SHELLS => true,
            WeaponsEnum::MANSTOPPER_SHELLS => true,
            WeaponsEnum::MISSILE_LAUNCHER_FRAG => true,
            WeaponsEnum::MISSILE_LAUNCHER_KRAK => true,
            // Enfoncers
            WeaponsEnum::COMBAT_RIFLE => true,
            WeaponsEnum::EXECUTIONER_SHELLS => false,
            WeaponsEnum::SUPPRESSIVE_SHIELD => true,
            WeaponsEnum::WEB_LAUNCHER => true,
        };
    }
}