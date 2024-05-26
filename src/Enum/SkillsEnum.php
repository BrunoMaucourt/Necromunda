<?php

declare(strict_types=1);

namespace App\Enum;

enum SkillsEnum: string
{
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

    public function getAgilitySkills(): int
    {
        return match($this) {
            self::AgilityCatfall => 1,
            self::AgilityDodge => 2,
            self::AgilityJumpBack => 3,
            self::AgilityLeap => 4,
            self::AgilityQuickWitted => 5,
            self::AgilitySprint => 6,
        };
    }

    public function getCombatSkills(): int
    {
        return match($this) {
            self::CombatCombatMaster => 1,
            self::CombatCounterAttack => 2,
            self::CombatDeflect => 3,
            self::CombatDisarm => 4,
            self::CombatFeint => 5,
            self::CombatStepAside => 6,
        };
    }
    public function getFerocitySkills(): int
    {
        return match($this) {
            self::FerocityBerserkCharge => 1,
            self::FerocityImpetuous => 2,
            self::FerocityIronWill => 3,
            self::FerocityKillerReputation => 4,
            self::FerocityNervesofSteel => 5,
            self::FerocityTrueGrit => 6,
        };
    }

    public function getMuscleSkills(): int
    {
        return match($this) {
            self::MuscleBodySlam => 1,
            self::MuscleBulgingBiceps => 2,
            self::MuscleHardasNails => 3,
            self::MuscleHurlOpponent => 4,
            self::MuscleIronJaw => 5,
            self::MuscleJuggernaut => 6,
        };
    }
    public function getShootingSkills(): int
    {
        return match($this) {
            self::ShootingCrackShot => 1,
            self::ShootingFastShot => 2,
            self::ShootingGunfighter => 3,
            self::ShootingHipShooting => 4,
            self::ShootingMarksman => 5,
            self::ShootingRapidFire => 6,
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