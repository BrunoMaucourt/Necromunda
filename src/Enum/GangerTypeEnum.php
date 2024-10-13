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
    case sergeant = 'sergeant';
    case heavy_unit = 'heavy unit';
    case special_unit = 'special unit';
    case canine_unit = 'canine unit';
    case cyber_mastiff = 'cyber mastiff';
    case enforcer = 'enforcer';
    const GANG = 'gang';
    const HIRED_GUNS = 'hired guns';
    const ENFONCERS = 'enfoncers';

    public function enumToString(): string
    {
        return match($this)
        {
            self::leader => GangerTypeEnum::leader->value,
            self::heavy => GangerTypeEnum::heavy->value,
            self::ganger => GangerTypeEnum::ganger->value,
            self::juve =>  GangerTypeEnum::juve->value,
            self::underhive_scum => GangerTypeEnum::underhive_scum->value,
            self::bounty_hunter => GangerTypeEnum::bounty_hunter->value,
            self::ratskin_scout => GangerTypeEnum::ratskin_scout->value,
            self::sergeant => GangerTypeEnum::sergeant->value,
            self::heavy_unit => GangerTypeEnum::heavy_unit->value,
            self::special_unit => GangerTypeEnum::special_unit->value,
            self::canine_unit => GangerTypeEnum::canine_unit->value,
            self::cyber_mastiff => GangerTypeEnum::cyber_mastiff->value,
            self::enforcer => GangerTypeEnum::enforcer->value,
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
            self::sergeant => self::ENFONCERS,
            self::heavy_unit => self::ENFONCERS,
            self::special_unit => self::ENFONCERS,
            self::canine_unit => self::ENFONCERS,
            self::cyber_mastiff => self::ENFONCERS,
            self::enforcer => self::ENFONCERS,
        };
    }

    public function getCost(): int
    {
        return match($this)
        {
            self::leader => 120,
            self::heavy => 60,
            self::ganger => 50,
            self::juve => 25,
            self::underhive_scum => 15,
            self::bounty_hunter => 35,
            self::ratskin_scout => 15,
            self::sergeant => 0,
            self::heavy_unit => 0,
            self::special_unit => 0,
            self::canine_unit => 0,
            self::cyber_mastiff => 0,
            self::enforcer => 0,
        };
    }

    public function isAvailableOnMenu(): bool
    {
        return match($this)
        {
            self::leader => true,
            self::heavy => true,
            self::ganger => true,
            self::juve => true,
            self::underhive_scum => true,
            self::bounty_hunter => true,
            self::ratskin_scout => true,
            self::sergeant => true,
            self::heavy_unit => true,
            self::special_unit => true,
            self::canine_unit => true,
            self::cyber_mastiff => false,
            self::enforcer => true,
        };
    }
}