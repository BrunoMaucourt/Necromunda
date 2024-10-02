<?php

declare(strict_types=1);

namespace App\Enum;

enum SpecialWeaponEnum: string
{
    case Ammo_Roll = "Ammo Roll";
    case Armor = "Armor";
    case Blast = "blast";
    case Blind = "Blind";
    case Capture = "Capture";
    case Catch_Fire_3 = "Catch Fire (3+)";
    case Catch_Fire_4 = "Catch Fire (4+)";
    case Catch_Fire_5 = "Catch Fire (5+)";
    case Choke = "Choke";
    case Clumsy = "Clumsy";
    case Critical_Shot = "Critical Shot";
    case Demolition = "Demolition";
    case Demolition_Only = "Demolition Only";
    case Disperse = "Disperse";
    case Draws = "Draws";
    case Dual_handed = "Dual-handed";
    case Dum_dum_Bullets = "Dum-dum Bullets";
    case Flamer = "Flamer";
    case Flare = "Flare";
    case Gas_Cloud = "Gas Cloud";
    case Gets_Hot = "Gets Hot";
    case Hallucinogen = "Hallucinogen";
    case High_Impact = "High Impact";
    case Injury = "Injury";
    case Injuries = "Injuries";
    case Knock_back = "Knock-back";
    case Mighty_Blow = "Mighty Blow";
    case Minus_1_to_Hit = "-1 to Hit";
    case Move_And_Fire = "Move And Fire";
    case Noisy = "Noisy";
    case Nullify = "Nullify";
    case Out_of_Action = "Out of Action";
    case Parry = "Parry";
    case Plasma_Gun = "Plasma Gun";
    case Saturation = "Saturation";
    case Scare = "Scare";
    case Silent = "Silent";
    case Smoke = "smoke";
    case Sustained_Fire_1 = "Sustained Fire (1)";
    case Sustained_Fire_2 = "Sustained Fire (2)";
    case Terrifying_Force = "Terrifying Force";
    case Toxic_Dart = "Toxic Dart";
    case Two_handed = "Two-handed";
    case Web_Solvent = "Web Solvent";
    case Webbed_Targets = "Webbed Targets";

    public function enumToString(): string
    {
        return match($this)
        {
            self::Ammo_Roll => self::Ammo_Roll->value,
            self::Armor => self::Armor->value,
            self::Blast => self::Blast->value,
            self::Blind => self::Blind->value,
            self::Capture => self::Capture->value,
            self::Catch_Fire_3 => self::Catch_Fire_3->value,
            self::Catch_Fire_4 => self::Catch_Fire_4->value,
            self::Catch_Fire_5 => self::Catch_Fire_5->value,
            self::Choke => self::Choke->value,
            self::Clumsy => self::Clumsy->value,
            self::Critical_Shot => self::Critical_Shot->value,
            self::Demolition => self::Demolition->value,
            self::Demolition_Only => self::Demolition_Only->value,
            self::Disperse => self::Disperse->value,
            self::Draws => self::Draws->value,
            self::Dual_handed => self::Dual_handed->value,
            self::Dum_dum_Bullets => self::Dum_dum_Bullets->value,
            self::Flamer => self::Flamer->value,
            self::Flare => self::Flare->value,
            self::Gas_Cloud => self::Gas_Cloud->value,
            self::Gets_Hot => self::Gets_Hot->value,
            self::Hallucinogen => self::Hallucinogen->value,
            self::High_Impact => self::High_Impact->value,
            self::Injury => self::Injury->value,
            self::Injuries => self::Injuries->value,
            self::Knock_back => self::Knock_back->value,
            self::Mighty_Blow => self::Mighty_Blow->value,
            self::Minus_1_to_Hit => self::Minus_1_to_Hit->value,
            self::Move_And_Fire => self::Move_And_Fire->value,
            self::Noisy => self::Noisy->value,
            self::Nullify => self::Nullify->value,
            self::Out_of_Action => self::Out_of_Action->value,
            self::Parry => self::Parry->value,
            self::Plasma_Gun => self::Plasma_Gun->value,
            self::Saturation => self::Saturation->value,
            self::Scare => self::Scare->value,
            self::Silent => self::Silent->value,
            self::Smoke => self::Smoke->value,
            self::Sustained_Fire_1 => self::Sustained_Fire_1->value,
            self::Sustained_Fire_2 => self::Sustained_Fire_2->value,
            self::Terrifying_Force => self::Terrifying_Force->value,
            self::Toxic_Dart => self::Toxic_Dart->value,
            self::Two_handed => self::Two_handed->value,
            self::Web_Solvent => self::Web_Solvent->value,
            self::Webbed_Targets => self::Webbed_Targets->value,
        };
    }

    public function getDescription(): string
    {
        return match($this)
        {
            self::Ammo_Roll => "The heavy flamer must roll for Ammo each time it fires.",
            self::Armor => "Grants a 5+ armor save against close combat hits and ranged attacks within a 90° arc in front of the enforcer.",
            self::Blast => "The weapon uses a small blast template.",
            self::Blind => "This weapon emits a flash or smoke, temporarily blinding the target and reducing their accuracy.",
            self::Capture => "A web pistol can capture an enemy in hand-to-hand combat on a roll of 4+.",
            self::Catch_Fire_3 => "Targets hit by a hand flamer catch fire on a roll of 3+.",
            self::Catch_Fire_4 => "Targets hit by a hand flamer catch fire on a roll of 4+.",
            self::Catch_Fire_5 => "Targets hit by a hand flamer catch fire on a roll of 5+.",
            self::Choke => "A gas cloud that chokes targets, causing them to pass out or be incapacitated.",
            self::Clumsy => "Flails double the effect of fumbles, increasing the opponent’s Combat Score.",
            self::Critical_Shot => "A stationary fighter with a hunting rifle deals D3 damage on a roll of 6 to wound.",
            self::Demolition => "Krak grenades can be affixed to structures for demolition.",
            self::Demolition_Only => "Melta bombs cannot be thrown or launched but are used for demolishing structures.",
            self::Disperse => "Gas clouds last several turns, dissipating or drifting based on a dice roll.",
            self::Draws => "If combat ends in a draw, the user's Initiative is halved for determining the winner.",
            self::Dual_handed => "A power axe can be wielded with one or both hands, gaining a strength bonus if dual-handed.",
            self::Dum_dum_Bullets => "These bullets increase the gun's Strength but can cause the weapon to explode on a failed Ammo roll.",
            self::Flamer => "The flamer uses a template for its shot and requires an Ammo roll each time it's fired.",
            self::Flare => "Targets a specific point. Models in the illuminated area can move and be targeted without considering penalties related to total darkness. Roll a D6 at the start of each player's turn; the flare remains lit on a 1-4 and extinguishes on a 5-6.",
            self::Gas_Cloud => "Frag grenades use a gas cloud template, affecting a wide area.",
            self::Gets_Hot => "If the plasma gun overheats, it explodes, inflicting a hit on the user.",
            self::Hallucinogen => "This gas cloud causes hallucinations, making the victim act unpredictably.",
            self::High_Impact => "This weapon deals massive damage, capable of knocking targets off their feet or through walls.",
            self::Injury => "Shock maul victims roll on a special injury chart instead of the standard one.",
            self::Injuries => "Toxic dart victims use a special injury chart for recovery.",
            self::Knock_back => "Shotgun hits can knock targets off balance, penalizing their Initiative.",
            self::Mighty_Blow => "Charging with a massive weapon reduces the opponent’s attack dice by one.",
            self::Minus_1_to_Hit => "Krak grenades impose a -1 penalty when thrown, but not when fired from a launcher.",
            self::Move_And_Fire => "The heavy flamer can be fired while moving, like a regular gun.",
            self::Noisy => "This weapon makes a loud sound and can trigger an alarm during certain scenarios.",
            self::Nullify => "Flails cancel out the opponent's parry.",
            self::Out_of_Action => "A fighter hit by a shock maul automatically goes out of action.",
            self::Parry => "Allows a fighter with a sword to force an opponent to re-roll a higher Attack dice, unless the opponent's roll is lower or both are armed with swords.",
            self::Plasma_Gun => "Fires unstable energy shells with varying power, using blast or gas cloud templates.",
            self::Saturation => "Scatter shots ignore cover modifiers and can hit multiple targets in close proximity.",
            self::Smoke => "This weapon emits a flash or smoke, temporarily blinding the target and reducing their accuracy.",
            self::Scare => "This weapon emits a terrifying sound or effect, causing fear tests in enemies.",
            self::Silent => "This weapon is silent and does not trigger alarms during stealth scenarios.",
            self::Sustained_Fire_1 => "The weapon has a sustained fire of 1 dice.",
            self::Sustained_Fire_2 => "The weapon has a sustained fire of 2 dices.",
            self::Terrifying_Force => "Lascannon blasts cause nearby friendly fighters to take nerve tests.",
            self::Toxic_Dart => "Automatically inflicts a wound without a roll, but only affects living targets.",
            self::Two_handed => "A massive weapon requires two hands and cannot be used with another weapon.",
            self::Web_Solvent => "Web pistols have a solvent to free webbed targets, but cannot free the user.",
            self::Webbed_Targets => "A web pistol ensnares the target, preventing movement and requiring a Strength test to escape.",
        };
    }
}