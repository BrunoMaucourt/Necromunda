<?php

declare(strict_types=1);

namespace App\Enum;

enum HouseEnum: string
{
    case Cawdor = 'Cawdor';
    case Delaque = 'Delaque';
    case Escher = 'Escher';
    case Goliath = 'Goliath';
    case Orlock = 'Orlock';
    case VanSaar = 'Van saar';

    public function enumToString(): string
    {
        return match($this)
        {
            self::Cawdor => HouseEnum::Cawdor->value,
            self::Delaque => HouseEnum::Delaque->value,
            self::Escher =>  HouseEnum::Escher->value,
            self::Goliath => HouseEnum::Goliath->value,
            self::Orlock =>  HouseEnum::Orlock->value,
            self::VanSaar =>  HouseEnum::VanSaar->value,
        };
    }
}