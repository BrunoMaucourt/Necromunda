<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/assets',
        __DIR__ . '/config',
        __DIR__ . '/migrations',
        __DIR__ . '/public',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    // uncomment to reach your current PHP version
    // ->withPhpSets()
    ->withRules([
//        AddVoidReturnTypeWhereNoReturnRector::class,
    ])
    ->withConfiguredRule(
        RenameClassRector::class, [
            'App\Entity\Equipements' => 'App\Entity\Equipement',
            'App\Entity\Games' => 'App\Entity\Game',
            'App\Entity\Injuries' => 'App\Entity\Injury',
            'App\Entity\Skills' => 'App\Entity\Skill',
            'App\Entity\Territories' => 'App\Entity\Territory',
            'App\Entity\Weapons' => 'App\Entity\Weapon',
        ]
    )
;