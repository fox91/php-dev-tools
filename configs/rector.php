<?php
declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\Configuration\Option;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\SetList;

// https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md

return static function (RectorConfig $rectorConfig): void
{
    $searchPaths = [
        __DIR__.'/bin',
        __DIR__.'/public',
        __DIR__.'/src',
        __DIR__.'/tests',
    ];
    $paths = array_merge([
        __DIR__.'/rector.php',
    ], array_filter($searchPaths, 'file_exists'));

    $rectorConfig->sets([
        PHPUnitSetList::PHPUNIT_91,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        PHPUnitSetList::PHPUNIT_EXCEPTION,
        PHPUnitSetList::PHPUNIT_MOCK,
        PHPUnitSetList::PHPUNIT_SPECIFIC_METHOD,
        PHPUnitSetList::PHPUNIT_YIELD_DATA_PROVIDER,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::NAMING,
        SetList::PHP_74,
        SetList::PRIVATIZATION,
        SetList::TYPE_DECLARATION,
        SetList::UNWRAP_COMPAT,
    ]);
    $rectorConfig->parallel();
    $rectorConfig->paths($paths);
    $rectorConfig->phpstanConfig(__DIR__.'/phpstan.neon.dist');
    $rectorConfig->skip([
        \Rector\CodeQuality\Rector\ClassMethod\DateTimeToDateTimeInterfaceRector::class,
        \Rector\CodeQuality\Rector\Equal\UseIdenticalOverEqualWithSameTypeRector::class,
        \Rector\CodeQuality\Rector\If_\ShortenElseIfRector::class,
        \Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector::class,
        \Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector::class,
        \Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector::class,
        \Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector::class,
        \Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector::class,
        \Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector::class,
        \Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector::class,
        \Rector\Privatization\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector::class,
        \Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector::class,
        \Rector\Privatization\Rector\Class_\RepeatedLiteralToClassConstantRector::class,
    ]);

    $parameters = $rectorConfig->parameters();
    $parameters->set(Option::CACHE_DIR, __DIR__.'/build/cache/rector');
};
