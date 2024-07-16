<?php

declare(strict_types=1);

namespace App\Enum;

enum InjuriesEnum: string
{
    case Dead = 'Dead';
    case MultipleInjuries = 'Multiple injuries';
    case InfectedWound1 = 'Infected wound 1 game';
    case InfectedWound2 = 'Infected wound 2 games';
    case InfectedWound3 = 'Infected wound 3 games';
    case ChestWound = 'Chest wound';
    case LegWound = 'Leg wound';
    case ArmWound = 'Arm wound';
    case HeadWound = 'Head wound';
    case BlindedInOneEye = 'Blinded in one eye';
    case PartiallyDeafened = 'Partially deafened';
    case ShellShock = 'Shell shock';
    case HandInjury = 'Hand injury';
    case OldBattleWound = 'Old battle wound';
    case FullRecovery = 'Full recovery';
    case BitterEnmity = 'Bitter enmity';
    case Captured = 'Captured';
    case HorribleScar = 'Horrible scars';
    case ImpressiveScars = 'Impressive scars';
    case SurvivesAgainstTheOdds = 'Survives against the odds';

    public function enumToString(): string
    {
        return match($this)
        {
            self::Dead => InjuriesEnum::Dead->value,
            self::MultipleInjuries => InjuriesEnum::MultipleInjuries->value,
            self::InfectedWound1 => InjuriesEnum::InfectedWound1->value,
            self::InfectedWound2 => InjuriesEnum::InfectedWound2->value,
            self::InfectedWound3 => InjuriesEnum::InfectedWound3->value,
            self::ChestWound => InjuriesEnum::ChestWound->value,
            self::LegWound => InjuriesEnum::LegWound->value,
            self::ArmWound => InjuriesEnum::ArmWound->value,
            self::HeadWound => InjuriesEnum::HeadWound->value,
            self::BlindedInOneEye => InjuriesEnum::BlindedInOneEye->value,
            self::PartiallyDeafened => InjuriesEnum::PartiallyDeafened->value,
            self::ShellShock => InjuriesEnum::ShellShock->value,
            self::HandInjury => InjuriesEnum::HandInjury->value,
            self::OldBattleWound => InjuriesEnum::OldBattleWound->value,
            self::FullRecovery => InjuriesEnum::FullRecovery->value,
            self::BitterEnmity => InjuriesEnum::BitterEnmity->value,
            self::Captured => InjuriesEnum::Captured->value,
            self::HorribleScar => InjuriesEnum::HorribleScar->value,
            self::ImpressiveScars => InjuriesEnum::ImpressiveScars->value,
            self::SurvivesAgainstTheOdds => InjuriesEnum::SurvivesAgainstTheOdds->value,
        };
    }

    public function getDicesRange(): string
    {
        return match($this)
        {
            self::Dead => '11-15',
            self::MultipleInjuries => '16-16',
            self::InfectedWound1 => '211-211',
            self::InfectedWound2 => '212-212',
            self::InfectedWound3 => '213-213',
            self::ChestWound => '22-22',
            self::LegWound => '23-23',
            self::ArmWound => '24-24',
            self::HeadWound => '25-25',
            self::BlindedInOneEye => '26-26',
            self::PartiallyDeafened => '31-31',
            self::ShellShock => '32-32',
            self::HandInjury => '33-33',
            self::OldBattleWound => '34-36',
            self::FullRecovery => '41-55',
            self::BitterEnmity => '56-56',
            self::Captured => '61-63',
            self::HorribleScar => '64-64',
            self::ImpressiveScars => '65-65',
            self::SurvivesAgainstTheOdds => '66-66',
        };
    }

    public function getEffect(): string
    {
        return match($this)
        {
            self::Dead => '',
            self::MultipleInjuries => '',
            self::InfectedWound1 => '',
            self::InfectedWound2 => '',
            self::InfectedWound3 => '',
            self::ChestWound => '',
            self::LegWound => '',
            self::ArmWound => '',
            self::HeadWound => '',
            self::BlindedInOneEye => '',
            self::PartiallyDeafened => '',
            self::ShellShock => '',
            self::HandInjury => '',
            self::OldBattleWound => '',
            self::FullRecovery => '',
            self::BitterEnmity => '',
            self::Captured => '',
            self::HorribleScar => '',
            self::ImpressiveScars => '',
            self::SurvivesAgainstTheOdds => '',
        };
    }
}