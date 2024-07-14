<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector;
use Rector\Config\RectorConfig;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfContinueToMultiContinueRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\Exception\Configuration\InvalidConfigurationException;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php81\Rector\FuncCall\NullToStrictStringFuncCallArgRector;
use Rector\TypeDeclaration\Rector\Closure\AddClosureVoidReturnTypeWhereNoReturnRector;

try {
    return RectorConfig::configure()
        ->withCache(
        // ensure file system caching is used instead of in-memory
            cacheDirectory: '.tmp/rector',

            // specify a path that works locally as well as on CI job runners
            cacheClass: FileCacheStorage::class
        )
        ->withPaths([
            __DIR__ . '/app',
            __DIR__ . '/config',
            __DIR__ . '/public',
            __DIR__ . '/resources',
            __DIR__ . '/routes',
        ])->withPhpSets(php82: true)
        ->withImportNames(removeUnusedImports: true)
        ->withRules(
            [
                ClassPropertyAssignToConstructorPromotionRector::class,
                StringClassNameToClassConstantRector::class,
            ]
        )
        ->withPreparedSets(deadCode: true,
            codeQuality: true,
            codingStyle: true,
            typeDeclarations: true,
            privatization: true,
            naming: false,
            instanceOf: true,
            earlyReturn: true,
            strictBooleans: true,
        )
        ->withSkip(
            [
                ChangeOrIfContinueToMultiContinueRector::class,
                ReturnBinaryOrToEarlyReturnRector::class,
                EncapsedStringsToSprintfRector::class,
                NullToStrictStringFuncCallArgRector::class,
                AddClosureVoidReturnTypeWhereNoReturnRector::class,
            ]);
} catch (InvalidConfigurationException $e) {
}
