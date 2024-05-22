<?php

declare(strict_types=1);

namespace App\Enum;

enum GangerTypeEnum: string
{
    case leader = 'leader';
    case heavy = 'heavy';
    case ganger = 'ganger';
    case juve = 'juve';

    public function enumToString(): string
    {
        return match($this)
        {
            self::leader => GangerTypeEnum::leader->value,
            self::heavy => GangerTypeEnum::heavy->value,
            self::ganger => GangerTypeEnum::ganger->value,
            self::juve =>  GangerTypeEnum::juve->value,
        };
    }
}