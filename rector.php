<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\Config\RectorConfig;
use Rector\Exception\Configuration\InvalidConfigurationException;
use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorLaravel\Rector\Class_\AddHasFactoryToModelsRector;
use RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector;
use RectorLaravel\Rector\MethodCall\ResponseHelperCallToJsonResponseRector;
use RectorLaravel\Rector\MethodCall\WhereToWhereLikeRector;
use RectorLaravel\Rector\StaticCall\RouteActionCallableRector;
use RectorLaravel\Set\LaravelSetList;
use RectorLaravel\Set\LaravelSetProvider;

try {
    return RectorConfig::configure()
        ->withSetProviders(LaravelSetProvider::class)
        ->withComposerBased(laravel: true/** other options */)
        ->withCache(
            // ensure file system caching is used instead of in-memory
            cacheDirectory: '.tmp/rector',

            // specify a path that works locally as well as on CI job runners
            cacheClass: FileCacheStorage::class
        )
        ->withImportNames(removeUnusedImports: true)
        ->withsets([
            LaravelSetList::LARAVEL_CODE_QUALITY,
            LaravelSetList::LARAVEL_CONTAINER_STRING_TO_FULLY_QUALIFIED_NAME,
            LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
            LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER,
            LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,
            LaravelSetList::LARAVEL_COLLECTION,
            LaravelSetList::LARAVEL_ARRAYACCESS_TO_METHOD_CALL,
            LaravelSetList::ARRAY_STR_FUNCTIONS_TO_STATIC_CALL,
            LaravelSetList::LARAVEL_TYPE_DECLARATIONS,
            LaravelSetList::LARAVEL_FACADE_ALIASES_TO_FULL_NAMES,
            LaravelSetList::LARAVEL_FACTORIES,
            LaravelSetList::LARAVEL_IF_HELPERS,
            LaravelSetList::LARAVEL_TESTING,
        ])
        ->withConfiguredRule(WhereToWhereLikeRector::class, [
            WhereToWhereLikeRector::USING_POSTGRES_DRIVER => false,
        ])
        ->withConfiguredRule(RouteActionCallableRector::class, [
            RouteActionCallableRector::NAMESPACE => 'App\Http\Controllers',
        ])
        ->withRules([
            ResponseHelperCallToJsonResponseRector::class,
        ])
        ->withSkip([
            EloquentOrderByToLatestOrOldestRector::class,
            RenameClassRector::class,
            AddHasFactoryToModelsRector::class,
        ])
        ->withPaths([
            __DIR__.'/app',
            __DIR__.'/config',
            __DIR__.'/routes',
            __DIR__.'/resources/views',
            __DIR__.'/tests',
            __DIR__.'/database',
        ]);
} catch (InvalidConfigurationException $e) {
}
