<?php

declare(strict_types=1);

namespace App\Enum;

enum TerritoriesEnum: string
{
    case ChemPit = 'Chem pit';
    case OldRuins = 'Old ruins';
    case Slag = 'Slag';
    case WaterStill = 'Water still';
    case Settlement = 'Settlement';
    case MineWorkings = 'Mine Workings';
    case Tunnels = 'Tunnels';
    case Vents = 'Vents';
    case Holestead = 'Holestead';
    case DrinkingHole = 'Drinking hole';
    case Workshop = 'Workshop';
    case GuilderContact = 'Guilder contact';
    case MineralOutcrop = 'Mineral outcrop';
    case FriendlyDoc = 'Friendly doc';
    case GamblingDen = 'Gambling den';
    case SporeCave = 'Spore cave';
    case ArcheotechHoard = 'Archeotech hoard';
    case GreenHivers = 'Green hivers';

    public function enumToString(): string
    {
        return match($this)
        {
            self::ChemPit => TerritoriesEnum::ChemPit->value,
            self::OldRuins => TerritoriesEnum::OldRuins->value,
            self::Slag => TerritoriesEnum::Slag->value,
            self::WaterStill => TerritoriesEnum::WaterStill->value,
            self::Settlement => TerritoriesEnum::Settlement->value,
            self::MineWorkings => TerritoriesEnum::MineWorkings->value,
            self::Tunnels => TerritoriesEnum::Tunnels->value,
            self::Vents => TerritoriesEnum::Vents->value,
            self::Holestead => TerritoriesEnum::Holestead->value,
            self::DrinkingHole => TerritoriesEnum::DrinkingHole->value,
            self::Workshop => TerritoriesEnum::Workshop->value,
            self::GuilderContact => TerritoriesEnum::GuilderContact->value,
            self::MineralOutcrop => TerritoriesEnum::MineralOutcrop->value,
            self::FriendlyDoc => TerritoriesEnum::FriendlyDoc->value,
            self::GamblingDen => TerritoriesEnum::GamblingDen->value,
            self::SporeCave => TerritoriesEnum::SporeCave->value,
            self::ArcheotechHoard => TerritoriesEnum::ArcheotechHoard->value,
            self::GreenHivers => TerritoriesEnum::GreenHivers->value,
        };
    }

    public function getFixedIncome(): int
    {
        return match($this)
        {
            self::ChemPit => 0,
            self::OldRuins => 10,
            self::Slag => 15,
            self::WaterStill =>  0,
            self::Settlement =>  30,
            self::MineWorkings =>  0,
            self::Tunnels =>  10,
            self::Vents =>  10,
            self::Holestead =>  0,
            self::DrinkingHole =>  0,
            self::Workshop =>  0,
            self::GuilderContact =>  0,
            self::MineralOutcrop =>  0,
            self::FriendlyDoc =>  0,
            self::GamblingDen =>  0,
            self::SporeCave =>  0,
            self::ArcheotechHoard =>  0,
            self::GreenHivers =>  0,
        };
    }

    public function getVariableIncomeNumberOfDice(): int
    {
        return match($this)
        {
            self::ChemPit => 2,
            self::OldRuins => 0,
            self::Slag => 0,
            self::WaterStill =>  1,
            self::Settlement =>  0,
            self::MineWorkings =>  1,
            self::Tunnels =>  0,
            self::Vents =>  0,
            self::Holestead =>  1,
            self::DrinkingHole =>  1,
            self::Workshop =>  1,
            self::GuilderContact =>  1,
            self::MineralOutcrop =>  1,
            self::FriendlyDoc =>  1,
            self::GamblingDen =>  2,
            self::SporeCave =>  2,
            self::ArcheotechHoard =>  2,
            self::GreenHivers =>  0,
        };
    }

    public function getVariableIncomeMultiplicator(): int
    {
        return match($this)
        {
            self::ChemPit => 1,
            self::OldRuins => 0,
            self::Slag => 0,
            self::WaterStill =>  10,
            self::Settlement =>  0,
            self::MineWorkings =>  10,
            self::Tunnels =>  0,
            self::Vents =>  0,
            self::Holestead =>  10,
            self::DrinkingHole =>  10,
            self::Workshop =>  10,
            self::GuilderContact =>  10,
            self::MineralOutcrop =>  10,
            self::FriendlyDoc =>  10,
            self::GamblingDen =>  10,
            self::SporeCave =>  10,
            self::ArcheotechHoard =>  10,
            self::GreenHivers =>  0,
        };
    }

    public function getDicesRange(): string
    {
        return match($this)
        {
            self::ChemPit => '11-12',
            self::OldRuins => '13-16',
            self::Slag => '21-24',
            self::WaterStill => '25-26',
            self::Settlement => '31-34',
            self::MineWorkings => '35-36',
            self::Tunnels => '41-42',
            self::Vents => '43-44',
            self::Holestead => '45-46',
            self::DrinkingHole => '51-52',
            self::Workshop => '53-54',
            self::GuilderContact => '55-56',
            self::MineralOutcrop => '61-61',
            self::FriendlyDoc =>  '62-62',
            self::GamblingDen =>  '63-63',
            self::SporeCave =>  '64-64',
            self::ArcheotechHoard =>  '65-65',
            self::GreenHivers => '66-66',
        };
    }

    public function getEffect(): string
    {
        return match($this)
        {
            self::ChemPit => 'If double roll, no incone collected and ganger cause fear',
            self::OldRuins => '',
            self::Slag => '',
            self::WaterStill => '',
            self::Settlement => 'If dice roll 6, recruit for free a juve',
            self::MineWorkings => 'If an enemy fighter is captured, he can work in mine and add +1 to this income D6',
            self::Tunnels => 'Three fighters can be deployed anywhere at ground level',
            self::Vents => 'Three fighters can be deployed anywhere on buildings surface',
            self::Holestead => '',
            self::DrinkingHole => 'If dice roll 6, +1 or -1 for next scenario table roll',
            self::Workshop => 'First ammo roll can be ignored',
            self::GuilderContact => 'Each loot discovered can be trade for +5 credits',
            self::MineralOutcrop => 'If dice roll 6, add D6 X 10 credits',
            self::FriendlyDoc =>  'If a fighter dead, roll a D6, for 5+ he get multiple injuries instead dead',
            self::GamblingDen =>  'If double roll, you lose this credits',
            self::SporeCave =>  'If double roll 1, ganger is sicke and can take part to next battle on 4+ with a D6',
            self::ArcheotechHoard =>  'Can collect 3 to 6 D6 X10 but if double roll, territory become Old ruins',
            self::GreenHivers => 'Choose another territory',
        };
    }
}