<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\Config\RectorConfig;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;

return RectorConfig::configure()
    ->withCache(
        // ensure file system caching is used instead of in-memory
        cacheDirectory: '.tmp/rector',

        // specify a path that works locally as well as on CI job runners
        cacheClass: FileCacheStorage::class
    )
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/config',
        __DIR__.'/public',
        __DIR__.'/resources',
        __DIR__.'/routes',
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
        earlyReturn: true,
        strictBooleans: false)
    ->withSkip(
        [
            Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector::class,
            Rector\EarlyReturn\Rector\If_\ChangeOrIfContinueToMultiContinueRector::class,
            Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector::class,
        ]);
