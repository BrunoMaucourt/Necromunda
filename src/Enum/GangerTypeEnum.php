<?php

declare(strict_types=1);

namespace App\Enum;

enum GangerTypeEnum: string
{
    case leader = 'leader';
    case heavy = 'heavy';
    case ganger = 'ganger';
    case juve = 'juve';
    case underhive_scum = 'underhive scum';
    case bounty_hunter = 'bounty hunter';
    case ratskin_scout = 'ratskin scout';

    const GANG = 'gang';
    const HIRED_GUNS = 'hired guns';

    public function enumToString(): string
    {
        return match($this)
        {
            self::leader => GangerTypeEnum::leader->value,
            self::heavy => GangerTypeEnum::heavy->value,
            self::ganger => GangerTypeEnum::ganger->value,
            self::juve =>  GangerTypeEnum::juve->value,
            self::underhive_scum =>  GangerTypeEnum::underhive_scum->value,
            self::bounty_hunter =>  GangerTypeEnum::bounty_hunter->value,
            self::ratskin_scout =>  GangerTypeEnum::ratskin_scout->value,
        };
    }

    public function getType(): string
    {
        return match($this)
        {
            self::leader => self::GANG,
            self::heavy => self::GANG,
            self::ganger => self::GANG,
            self::juve => self::GANG,
            self::underhive_scum => self::HIRED_GUNS,
            self::bounty_hunter => self::HIRED_GUNS,
            self::ratskin_scout => self::HIRED_GUNS,
        };
    }
}