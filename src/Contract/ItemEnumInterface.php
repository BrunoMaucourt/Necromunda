<?php

namespace App\Contract;

interface ItemEnumInterface
{
    public function enumToString(): string;

    public function getFixedCost(): int;

    public function getVariableDicesNumber(): int;

    public function isCustomRules(): bool;
}