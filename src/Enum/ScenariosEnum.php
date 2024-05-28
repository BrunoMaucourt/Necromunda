<?php

declare(strict_types=1);

namespace App\Enum;

enum ScenariosEnum: string
{
    case GangFight = 'Gang fight';
    case Scavengers = 'Scavengers';
    case HitAndRun = 'Hit and run';
    case Ambush = 'Ambush';
    case TheRaid = 'The raid';
    case RescueMission = 'Rescue mission';
    case ShootOut = 'Shoot out';
    case TheHoard = 'The hoard';
    case PackageRun = 'Package run';
    case BlindFight = 'Blind fight';

    public function enumToString(): string
    {
        return match($this)
        {
            self::GangFight => ScenariosEnum::GangFight->value,
            self::Scavengers => ScenariosEnum::Scavengers->value,
            self::HitAndRun => ScenariosEnum::HitAndRun->value,
            self::Ambush => ScenariosEnum::Ambush->value,
            self::TheRaid => ScenariosEnum::TheRaid->value,
            self::RescueMission => ScenariosEnum::RescueMission->value,
            self::ShootOut => ScenariosEnum::ShootOut->value,
            self::TheHoard => ScenariosEnum::TheHoard->value,
            self::PackageRun => ScenariosEnum::PackageRun->value,
            self::BlindFight => ScenariosEnum::BlindFight->value,
        };
    }
}