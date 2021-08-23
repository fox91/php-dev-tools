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
        __DIR__.'/bin',
        __DIR__.'/public',
        __DIR__.'/src',
        __DIR__.'/tests',
    ];
    $paths = array_merge([
        __DIR__.'/rector.php',
    ], array_filter($searchPaths, 'file_exists'));

    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_91);
    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_CODE_QUALITY);
    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_EXCEPTION);
    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_MOCK);
    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_SPECIFIC_METHOD);
    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_YIELD_DATA_PROVIDER);
    $containerConfigurator->import(SetList::CODE_QUALITY);
    $containerConfigurator->import(SetList::CODE_QUALITY_STRICT);
    $containerConfigurator->import(SetList::CODING_STYLE);
    $containerConfigurator->import(SetList::DEAD_CODE);
    $containerConfigurator->import(SetList::NAMING);
    $containerConfigurator->import(SetList::PHP_74);
    $containerConfigurator->import(SetList::PRIVATIZATION);
    $containerConfigurator->import(SetList::TYPE_DECLARATION);
    $containerConfigurator->import(SetList::UNWRAP_COMPAT);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, $paths);
    $parameters->set(Option::CACHE_DIR, __DIR__.'/.rector.cache');
    $parameters->set(Option::IMPORT_DOC_BLOCKS, false);
    $parameters->set(Option::PHPSTAN_FOR_RECTOR_PATH, __DIR__.'/phpstan.neon.dist');
    $parameters->set(Option::SKIP, [
        \Rector\CodeQuality\Rector\ClassMethod\DateTimeToDateTimeInterfaceRector::class,
        \Rector\CodeQuality\Rector\Equal\UseIdenticalOverEqualWithSameTypeRector::class,
        \Rector\CodeQuality\Rector\If_\ShortenElseIfRector::class,
        \Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector::class,
        \Rector\CodingStyle\Rector\ClassMethod\RemoveDoubleUnderscoreInMethodNameRector::class,
        \Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector::class,
        \Rector\CodingStyle\Rector\FuncCall\ConsistentPregDelimiterRector::class,
        \Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector::class,
        \Rector\CodingStyle\Rector\Use_\RemoveUnusedAliasRector::class,
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
};
