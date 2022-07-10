<?php
declare(strict_types=1);

use Rector\CodeQuality\Rector\ClassMethod\DateTimeToDateTimeInterfaceRector;
use Rector\CodeQuality\Rector\Equal\UseIdenticalOverEqualWithSameTypeRector;
use Rector\CodeQuality\Rector\If_\ShortenElseIfRector;
use Rector\Config\RectorConfig;
use Rector\Core\Configuration\Option;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
use Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector;
use Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector;
use Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Privatization\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector;
use Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector;
use Rector\Privatization\Rector\Class_\RepeatedLiteralToClassConstantRector;
use Rector\Set\ValueObject\SetList;

// https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md

return static function (RectorConfig $rectorConfig): void {
    $searchPaths = [
        __DIR__ . '/bin',
        __DIR__ . '/public',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ];
    $paths = array_merge([
        __DIR__ . '/rector.php',
    ], array_filter($searchPaths, 'file_exists'));

    $rectorConfig->sets([
        PHPUnitSetList::PHPUNIT_91,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        PHPUnitSetList::PHPUNIT_EXCEPTION,
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
    $rectorConfig->phpstanConfig(__DIR__ . '/phpstan.neon.dist');
    $rectorConfig->skip([
        DateTimeToDateTimeInterfaceRector::class,
        UseIdenticalOverEqualWithSameTypeRector::class,
        ShortenElseIfRector::class,
        RemoveUnusedPromotedPropertyRector::class,
        RenameVariableToMatchMethodCallReturnTypeRector::class,
        RenameParamToMatchTypeRector::class,
        RenameVariableToMatchNewTypeRector::class,
        RenameForeachValueVariableToMatchExprVariableRector::class,
        RenameForeachValueVariableToMatchMethodCallReturnTypeRector::class,
        AddSeeTestAnnotationRector::class,
        ChangeReadOnlyVariableWithDefaultValueToConstantRector::class,
        FinalizeClassesWithoutChildrenRector::class,
        RepeatedLiteralToClassConstantRector::class,
    ]);

    $parameters = $rectorConfig->parameters();
    $parameters->set(Option::CACHE_DIR, __DIR__ . '/build/cache/rector');
};
