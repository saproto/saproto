<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
    ])->withPhpSets(php53: true)
    ->withRules(
        [
            ClassPropertyAssignToConstructorPromotionRector::class,
            StringClassNameToClassConstantRector::class,
        ]
    )
    ->withPreparedSets(deadCode: true,
        codeQuality: false,
        codingStyle: false,
        typeDeclarations: false,
        privatization: false,
        naming: false,
        instanceOf: false,
        earlyReturn: false,
        strictBooleans: false);