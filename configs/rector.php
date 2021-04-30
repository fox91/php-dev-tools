<?php
declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

// https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md

return static function (ContainerConfigurator $containerConfigurator): void
{
    $searchPaths = [
        __DIR__.'/public',
        __DIR__.'/src',
        __DIR__.'/tests',
    ];
    $paths = array_merge([
        __DIR__.'/rector.php',
    ], array_filter($searchPaths, 'file_exists'));

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, $paths);
    $parameters->set(Option::IMPORT_DOC_BLOCKS, false);
    $parameters->set(Option::ENABLE_CACHE, true);
    $parameters->set(Option::PHPSTAN_FOR_RECTOR_PATH, __DIR__.'/phpstan.neon.dist');
    $parameters->set(Option::SETS, [
        PHPUnitSetList::PHPUNIT_91,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        PHPUnitSetList::PHPUNIT_EXCEPTION,
        PHPUnitSetList::PHPUNIT_MOCK,
        PHPUnitSetList::PHPUNIT_SPECIFIC_METHOD,
        PHPUnitSetList::PHPUNIT_YIELD_DATA_PROVIDER,
        SetList::CODE_QUALITY,
        SetList::CODE_QUALITY_STRICT,
        SetList::CODING_STYLE,
        SetList::DEAD_CODE,
        SetList::NAMING,
        SetList::PHP_74,
        SetList::PRIVATIZATION,
        SetList::TYPE_DECLARATION,
        SetList::UNWRAP_COMPAT,
    ]);
    $parameters->set(Option::SKIP, [
        \Rector\CodeQuality\Rector\Equal\UseIdenticalOverEqualWithSameTypeRector::class,
        \Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector::class,
        \Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector::class,
        \Rector\CodingStyle\Rector\Use_\RemoveUnusedAliasRector::class,
        \Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector::class,
        \Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector::class,
        \Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector::class,
        \Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector::class,
        \Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector::class,
        \Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector::class,
        \Rector\Privatization\Rector\Class_\RepeatedLiteralToClassConstantRector::class,
    ]);
};
