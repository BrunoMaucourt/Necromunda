<?php

declare(strict_types=1);

namespace App\Enum;

enum SkillsEnum: string
{
    const AGILITY = 'Agility';
    const COMBAT = 'Combat';
    const FEROCITY = 'Ferocity';
    const MUSCLE = 'Muscle';
    const SHOOTING = 'Shooting';
    const STEALTH = 'Stealth';
    const TECHNO = 'Techno';

    case AgilityCatfall = 'Agility - Catfall';
    case AgilityDodge = 'Agility - Dodge';
    case AgilityJumpBack = 'Agility - Jump Back';
    case AgilityLeap = 'Agility - Leap';
    case AgilityQuickWitted = 'Agility - Quick Witted';
    case AgilitySprint = 'Agility - Sprint';

    case CombatCombatMaster = 'Combat - Combat Master';
    case CombatCounterAttack = 'Combat - Counter Attack';
    case CombatDeflect = 'Combat - Deflect';
    case CombatDisarm = 'Combat - Disarm';
    case CombatFeint = 'Combat - Feint';
    case CombatStepAside = 'Combat - Step Aside';

    case FerocityBerserkCharge = 'Ferocity - Berserk Charge';
    case FerocityImpetuous = 'Ferocity - Impetuous';
    case FerocityIronWill = 'Ferocity - Iron Will';
    case FerocityKillerReputation = 'Ferocity - Killer Reputation';
    case FerocityNervesofSteel = 'Ferocity - Nerves of Steel';
    case FerocityTrueGrit = 'Ferocity - True Grit';

    case MuscleBodySlam = 'Muscle - Body Slam';
    case MuscleBulgingBiceps = 'Muscle - Bulging Biceps';
    case MuscleHardasNails = 'Muscle - Hard as Nails';
    case MuscleHurlOpponent = 'Muscle - Hurl Opponent';
    case MuscleIronJaw = 'Muscle - Iron Jaw';
    case MuscleJuggernaut = 'Muscle - Juggernaut';

    case ShootingCrackShot = 'Shooting - Crack Shot';
    case ShootingFastShot = 'Shooting - Fast Shot';
    case ShootingGunfighter = 'Shooting - Gunfighter';
    case ShootingHipShooting = 'Shooting - Hip Shooting';
    case ShootingMarksman = 'Shooting - Marksman';
    case ShootingRapidFire = 'Shooting - Rapid Fire';

    case StealthAmbush = 'Stealth - Ambush';
    case StealthDive = 'Stealth - Dive';
    case StealthEscapeArtist = 'Stealth - Escape Artist';
    case StealthEvade = 'Stealth - Evade';
    case StealthInfiltration = 'Stealth - Infiltration';
    case StealthSneakUp = 'Stealth - Sneak Up';

    case TechnoArmourer = 'Techno - Armourer';
    case TechnoFixer = 'Techno - Fixer';
    case TechnoInventor = 'Techno - Inventor';
    case TechnoMedic = 'Techno - Medic';
    case TechnoSpecialist = 'Techno - Specialist';
    case TechnoWeaponsmith = 'Techno - Weaponsmith';

    public function enumToString(): string
    {
        return match($this)
        {
            self::AgilityCatfall => SkillsEnum::AgilityCatfall->value,
            self::AgilityDodge => SkillsEnum::AgilityDodge->value,
            self::AgilityJumpBack => SkillsEnum::AgilityJumpBack->value,
            self::AgilityLeap => SkillsEnum::AgilityLeap->value,
            self::AgilityQuickWitted => SkillsEnum::AgilityQuickWitted->value,
            self::AgilitySprint => SkillsEnum::AgilitySprint->value,
            self::CombatCombatMaster => SkillsEnum::CombatCombatMaster->value,
            self::CombatCounterAttack => SkillsEnum::CombatCounterAttack->value,
            self::CombatDeflect => SkillsEnum::CombatDeflect->value,
            self::CombatDisarm => SkillsEnum::CombatDisarm->value,
            self::CombatFeint => SkillsEnum::CombatFeint->value,
            self::CombatStepAside => SkillsEnum::CombatStepAside->value,
            self::FerocityBerserkCharge => SkillsEnum::FerocityBerserkCharge->value,
            self::FerocityImpetuous => SkillsEnum::FerocityImpetuous->value,
            self::FerocityIronWill => SkillsEnum::FerocityIronWill->value,
            self::FerocityKillerReputation => SkillsEnum::FerocityKillerReputation->value,
            self::FerocityNervesofSteel => SkillsEnum::FerocityNervesofSteel->value,
            self::FerocityTrueGrit => SkillsEnum::FerocityTrueGrit->value,
            self::MuscleBodySlam => SkillsEnum::MuscleBodySlam->value,
            self::MuscleBulgingBiceps => SkillsEnum::MuscleBulgingBiceps->value,
            self::MuscleHardasNails => SkillsEnum::MuscleHardasNails->value,
            self::MuscleHurlOpponent => SkillsEnum::MuscleHurlOpponent->value,
            self::MuscleIronJaw => SkillsEnum::MuscleIronJaw->value,
            self::MuscleJuggernaut => SkillsEnum::MuscleJuggernaut->value,
            self::ShootingCrackShot => SkillsEnum::ShootingCrackShot->value,
            self::ShootingFastShot => SkillsEnum::ShootingFastShot->value,
            self::ShootingGunfighter => SkillsEnum::ShootingGunfighter->value,
            self::ShootingHipShooting => SkillsEnum::ShootingHipShooting->value,
            self::ShootingMarksman => SkillsEnum::ShootingMarksman->value,
            self::ShootingRapidFire => SkillsEnum::ShootingRapidFire->value,
            self::StealthAmbush => SkillsEnum::StealthAmbush->value,
            self::StealthDive => SkillsEnum::StealthDive->value,
            self::StealthEscapeArtist => SkillsEnum::StealthEscapeArtist->value,
            self::StealthEvade => SkillsEnum::StealthEvade->value,
            self::StealthInfiltration => SkillsEnum::StealthInfiltration->value,
            self::StealthSneakUp => SkillsEnum::StealthSneakUp->value,
            self::TechnoArmourer => SkillsEnum::TechnoArmourer->value,
            self::TechnoFixer => SkillsEnum::TechnoFixer->value,
            self::TechnoInventor => SkillsEnum::TechnoInventor->value,
            self::TechnoMedic => SkillsEnum::TechnoMedic->value,
            self::TechnoSpecialist => SkillsEnum::TechnoSpecialist->value,
            self::TechnoWeaponsmith => SkillsEnum::TechnoWeaponsmith->value,
        };
    }

    public function getDescription(): string
    {
        return match($this)
        {
            self::AgilityCatfall => 'Safely land after a fall with an Initiative test; can jump from any height',
            self::AgilityDodge => 'Grants a 6+ special save against shooting and close combat hits',
            self::AgilityJumpBack => 'Allows disengagement from close combat by jumping back 2"',
            self::AgilityLeap => 'Adds D6" to movement if running or charging; can add the leap distance to jumps across gaps',
            self::AgilityQuickWitted => 'Before the game starts, allows an extra move phase action',
            self::AgilitySprint => 'Triples movement rate when running or charging',
            self::CombatCombatMaster => 'Negates enemy bonuses for multiple attackers; instead, the bonuses apply to the Combat Master',
            self::CombatCounterAttack => 'The fighter can re-roll one of his Attack dice in each hand-to-hand combat',
            self::CombatDeflect => 'Allows the fighter to force an opponent to re-roll one Attack dice in hand-to-hand combat',
            self::CombatDisarm => 'Test Initiative to force an opponent to fight with only a knife for a turn',
            self::CombatFeint => 'The first fumble in combat is treated as a critical hit, giving a +1 bonus to Combat Score',
            self::CombatStepAside => 'Grants a 4+ special save against hits in close combat',
            self::FerocityBerserkCharge => 'Adds D3 Attack dice when charging',
            self::FerocityImpetuous => 'Increases movement from 2" to 4" when pinned, down, or using a follow-up move',
            self::FerocityIronWill => 'Re-rolls failed nerve tests and Bottle rolls if the fighter\'s Leadership is used',
            self::FerocityKillerReputation => 'Causes fear due to the fighter\'s fearsome reputation',
            self::FerocityNervesofSteel => 'Allows early escape from pinning; if already allowed, re-rolls failed Initiative tests',
            self::FerocityTrueGrit => 'Treats a roll of 1-2 as a flesh wound on the injury chart',
            self::MuscleBodySlam => 'If the model charges, reduce the opponent\'s Weapon Skill to 1',
            self::MuscleBulgingBiceps => 'Grants a +1 Strength bonus',
            self::MuscleHardasNails => 'On a 5+, the fighter avoids serious injury and is treated as Fully Recovered',
            self::MuscleHurlOpponent => 'Allows throwing an opponent D6" in a chosen direction, pinning them',
            self::MuscleIronJaw => 'Reduces the Strength of close combat or short-range hits by 1',
            self::MuscleJuggernaut => 'Can ignore hits from overwatch if the Strength test is passed',
            self::ShootingCrackShot => 'Increases the chance to take an enemy out of action when making injury rolls from ranged attacks',
            self::ShootingFastShot => 'Allows overwatch even after moving, except if the model ran or charged',
            self::ShootingGunfighter => 'Enables firing a pistol in each hand for an additional attack',
            self::ShootingHipShooting => 'Allows shooting after running with a penalty to hit',
            self::ShootingMarksman => 'Allows ignoring the nearest target restriction with a successful Leadership test',
            self::ShootingRapidFire => 'Re-rolls failed to-hit dice if the model didn\'t move and is using a pistol or basic weapon',
            self::StealthAmbush => 'Allows the model to hide and go on overwatch in the same turn',
            self::StealthDive => 'Allows running and hiding in the same turn',
            self::StealthEscapeArtist => 'Automatically escapes if captured, treated as Full Recovery',
            self::StealthEvade => 'Reduces enemy shooting accuracy by -2 at short range and -1 at long range',
            self::StealthInfiltration => 'Allows deployment anywhere on the battlefield after the first turn, but not within 8" of an enemy',
            self::StealthSneakUp => 'Reduces the shooter’s Initiative to 1 when targeting this model on overwatch',
            self::TechnoArmourer => 'Ignores the first Ammo roll failure if the fighter wasn\'t taken out of action in the last game',
            self::TechnoFixer => 'Allows re-rolling the rarity value of one item when offered a rare item after the last game',
            self::TechnoInventor => 'Has a chance to invent a rare item after each battle if not taken out of action',
            self::TechnoMedic => 'Re-rolls one result on the Serious Injury table after the battle for another fighter',
            self::TechnoSpecialist => 'Allows the use of special weapons for fighters without access to them',
            self::TechnoWeaponsmith => 'Ignores failed Ammo rolls and weapon explosions on a D6 roll of 4+',
        };
    }

    public function getSkillCategory(): string
    {
        return match($this)
        {
            self::AgilityCatfall => SkillsEnum::AGILITY,
            self::AgilityDodge => SkillsEnum::AGILITY,
            self::AgilityJumpBack => SkillsEnum::AGILITY,
            self::AgilityLeap => SkillsEnum::AGILITY,
            self::AgilityQuickWitted => SkillsEnum::AGILITY,
            self::AgilitySprint => SkillsEnum::AGILITY,
            self::CombatCombatMaster => SkillsEnum::COMBAT,
            self::CombatCounterAttack => SkillsEnum::COMBAT,
            self::CombatDeflect => SkillsEnum::COMBAT,
            self::CombatDisarm => SkillsEnum::COMBAT,
            self::CombatFeint => SkillsEnum::COMBAT,
            self::CombatStepAside => SkillsEnum::COMBAT,
            self::FerocityBerserkCharge => SkillsEnum::FEROCITY,
            self::FerocityImpetuous => SkillsEnum::FEROCITY,
            self::FerocityIronWill => SkillsEnum::FEROCITY,
            self::FerocityKillerReputation => SkillsEnum::FEROCITY,
            self::FerocityNervesofSteel => SkillsEnum::FEROCITY,
            self::FerocityTrueGrit => SkillsEnum::FEROCITY,
            self::MuscleBodySlam => SkillsEnum::MUSCLE,
            self::MuscleBulgingBiceps => SkillsEnum::MUSCLE,
            self::MuscleHardasNails => SkillsEnum::MUSCLE,
            self::MuscleHurlOpponent => SkillsEnum::MUSCLE,
            self::MuscleIronJaw => SkillsEnum::MUSCLE,
            self::MuscleJuggernaut => SkillsEnum::MUSCLE,
            self::ShootingCrackShot => SkillsEnum::SHOOTING,
            self::ShootingFastShot => SkillsEnum::SHOOTING,
            self::ShootingGunfighter => SkillsEnum::SHOOTING,
            self::ShootingHipShooting => SkillsEnum::SHOOTING,
            self::ShootingMarksman => SkillsEnum::SHOOTING,
            self::ShootingRapidFire => SkillsEnum::SHOOTING,
            self::StealthAmbush => SkillsEnum::STEALTH,
            self::StealthDive => SkillsEnum::STEALTH,
            self::StealthEscapeArtist => SkillsEnum::STEALTH,
            self::StealthEvade => SkillsEnum::STEALTH,
            self::StealthInfiltration => SkillsEnum::STEALTH,
            self::StealthSneakUp => SkillsEnum::STEALTH,
            self::TechnoArmourer => SkillsEnum::TECHNO,
            self::TechnoFixer => SkillsEnum::TECHNO,
            self::TechnoInventor => SkillsEnum::TECHNO,
            self::TechnoMedic => SkillsEnum::TECHNO,
            self::TechnoSpecialist => SkillsEnum::TECHNO,
            self::TechnoWeaponsmith => SkillsEnum::TECHNO,
        };
    }

    public function getStealthSkills(): int
    {
        return match($this) {
            self::StealthAmbush => 1,
            self::StealthDive => 2,
            self::StealthEscapeArtist => 3,
            self::StealthEvade => 4,
            self::StealthInfiltration => 5,
            self::StealthSneakUp => 6,
        };
    }
    public function getTechnoSkills(): int
    {
        return match($this) {
            self::TechnoArmourer => 1,
            self::TechnoFixer => 2,
            self::TechnoInventor => 3,
            self::TechnoMedic => 4,
            self::TechnoSpecialist => 5,
            self::TechnoWeaponsmith => 6,
        };
    }
}