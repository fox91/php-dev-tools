<?php
declare(strict_types=1);

use Rector\Core\Configuration\Option;
// use Rector\Doctrine\Set\DoctrineSetList;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\SetList;
// use Rector\Symfony\Set\SymfonySetList;
// use Rector\Symfony\Set\TwigSetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

// https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md

return static function (ContainerConfigurator $containerConfigurator): void
{
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__.'/rector.php',
        __DIR__.'/src',
        __DIR__.'/tests',
    ]);
    // $parameters->set(Option::AUTO_IMPORT_NAMES, true);
    $parameters->set(Option::IMPORT_DOC_BLOCKS, false);
    $parameters->set(Option::ENABLE_CACHE, true);
    $parameters->set(Option::PHPSTAN_FOR_RECTOR_PATH, __DIR__.'/phpstan.neon.dist');
    $parameters->set(Option::SETS, [
        // DoctrineSetList::DOCTRINE_CODE_QUALITY,
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
        // SetList::PHP_80,
        SetList::PRIVATIZATION,
        // SetList::SAFE_07,
        SetList::TYPE_DECLARATION,
        SetList::UNWRAP_COMPAT,
        // SymfonySetList::SYMFONY_CODE_QUALITY,
        // SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
        // TwigSetList::TWIG_240,
        // TwigSetList::TWIG_UNDERSCORE_TO_NAMESPACE,
    ]);
    $parameters->set(Option::SKIP, [
        // PHPUnitSetList::PHPUNIT_91,
        \Rector\PHPUnit\Rector\Class_\AddSeeTestAnnotationRector::class,
        // PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        // PHPUnitSetList::PHPUNIT_EXCEPTION,
        // PHPUnitSetList::PHPUNIT_MOCK,
        // PHPUnitSetList::PHPUNIT_SPECIFIC_METHOD,
        // PHPUnitSetList::PHPUNIT_YIELD_DATA_PROVIDER,
        // SetList::CODE_QUALITY,
        // SetList::CODE_QUALITY_STRICT,
        // SetList::CODING_STYLE,
        \Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector::class,
        \Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector::class,
        \Rector\CodingStyle\Rector\Use_\RemoveUnusedAliasRector::class,
        // SetList::DEAD_CODE,
        // SetList::NAMING,
        \Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector::class,
        \Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector::class,
        \Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector::class,
        \Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector::class,
        // \Rector\Order\Rector\Class_\OrderMethodsByVisibilityRector::class,
        // SetList::PHP_74,
        // SetList::PRIVATIZATION,
        \Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector::class,
        \Rector\Privatization\Rector\Class_\RepeatedLiteralToClassConstantRector::class,
        // SetList::TYPE_DECLARATION,
        // SetList::UNWRAP_COMPAT,
    ]);
};
