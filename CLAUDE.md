# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is **fox91/dev-tools**, a Composer package that bundles PHP development tools with pre-configured settings. It's designed as a dependency package that other projects install to get a standardized set of quality assurance tools.

**Important**: This package has NO source code (no `src/` directory). It exists solely to bundle tools and provide default configurations via the `configs/` directory.

## PHP Version Support

Compatible with PHP 8.1, 8.2, 8.3, and 8.4.

## Development Commands

### Running Tests
```bash
composer test          # Run all tests (lint + code style)
composer lint:test     # PHP Parallel Lint only
composer cs:test       # PHP_CodeSniffer tests (all issues)
composer cs-e:test     # PHP_CodeSniffer tests (errors only)
```

### Fixing Code
```bash
composer fix           # Run all automatic fixes (currently just cs:fix)
composer cs:fix        # Auto-fix PHP_CodeSniffer issues with phpcbf
```

### Individual Tools (Not in Default Scripts)
The package includes these tools, but they're not wired up in this repository's composer.json:
- **Rector**: `composer rector:test` or `composer rector:fix` (if configured)
- **Psalm**: `composer psalm:test` (if configured)
- **PHPStan**: `composer phpstan:test` (if configured - optional dependency)
- **PHPUnit**: `composer unit:test` (if configured)

## Architecture

### Package Structure
```
configs/              # Default configuration files that consuming projects can copy
  .editorconfig       # Editor configuration
  .gitignore          # Git ignore patterns
  .phpcs.xml.dist     # PHP_CodeSniffer ruleset (uses Fox91CodingStandard)
  gitattributes.txt   # Git attributes (rename to .gitattributes)
  phpdoc.dist.xml     # PHPDocumentor configuration
  phpstan.neon.dist   # PHPStan static analysis config (level 6)
  phpunit.xml.dist    # PHPUnit testing framework config
  psalm.xml.dist      # Psalm static analysis config (errorLevel 1)
  rector.php          # Rector automated refactoring config (PHP 8.1+)
```

### Bundled Tools

**Core Dependencies** (always installed):
- `php-parallel-lint/php-parallel-lint` - Checks PHP syntax
- `squizlabs/php_codesniffer` - Code style checking and fixing (phpcs/phpcbf)
- `fox91/coding-standard` - Custom coding standard for PHP_CodeSniffer
- `phpunit/phpunit` - Unit testing framework (v10.5+)
- `vimeo/psalm` - Static analysis tool
- `psalm/plugin-phpunit` - PHPUnit plugin for Psalm
- `rector/rector` - Automated code refactoring and upgrades

**Optional Dependencies** (suggested, not required):
- `phpstan/phpstan` and various PHPStan extensions
- `thecodingmachine/safe` - PHP functions that throw exceptions instead of returning false

### Configuration Philosophy

All config files in `configs/` are designed to be **copied** into consuming projects. The standard installation pattern (documented in README) is:

```bash
composer require --dev fox91/dev-tools
cp vendor/fox91/dev-tools/configs/.* .
cp vendor/fox91/dev-tools/configs/rector.php .
# etc.
```

### Rector Configuration Details

The `configs/rector.php` file is pre-configured with:
- **Target PHP Level**: PHP 8.1 (`LevelSetList::UP_TO_PHP_81`)
- **Enabled Rule Sets**: CODE_QUALITY, DEAD_CODE, NAMING, PRIVATIZATION, TYPE_DECLARATION, PHPUNIT_CODE_QUALITY
- **Disabled Rules**: Several naming and code quality rules are explicitly skipped (see lines 34-44)
- **Search Paths**: Looks for `bin/`, `public/`, `src/`, `tests/` directories
- **Parallel Processing**: Enabled by default
- **Cache**: Stored in `build/cache/rector/`

### PHP_CodeSniffer Configuration Details

The `.phpcs.xml.dist` uses:
- **Coding Standard**: `Fox91CodingStandard` (from fox91/coding-standard package)
- **PHP Compatibility**: Minimum PHP 8.1
- **Parallel Processing**: 80 processes
- **ParanoiaMode**: Enabled (strict checking)
- **Default Paths**: `rector.php` and `src/` (bin, public, tests commented out)

### Psalm Configuration Details

The `psalm.xml.dist` uses:
- **Error Level**: 1 (strictest)
- **Plugin**: PHPUnit plugin enabled
- **Cache**: `build/cache/psalm/`
- **Default Path**: `src/` directory only

### PHPStan Configuration Details

The `phpstan.neon.dist` uses:
- **Level**: 6 (high strictness, but not maximum)
- **Cache**: `build/cache/phpstan/`
- **Default Paths**: `rector.php` and `src/`

## CI/CD

GitHub Actions workflow (`.github/workflows/php-ci.yml`):
- **Matrix Testing**: PHP 8.1, 8.2, 8.3, 8.4 × (lowest, highest) dependencies
- **Steps**:
  1. Composer validation (strict mode)
  2. PHP Parallel Lint
  3. PHP_CodeSniffer

**Note**: The workflow only runs lint and code style checks, NOT Psalm, PHPStan, Rector, or PHPUnit. This is because the package itself has no source code to analyze.

## Common Development Patterns

### Adding a New Configuration File

When adding new tool configs to the `configs/` directory:
1. Add the `.dist` version of the config
2. Update the README.md copy command examples
3. Ensure the config uses relative paths that work when copied to project root
4. Use commented-out sections for optional paths (bin, public, tests, etc.)

### Updating Tool Versions

When bumping tool versions in `composer.json`:
1. Test against all supported PHP versions (8.1-8.4)
2. Test with both `--prefer-lowest` and `--prefer-stable`
3. Update configuration files if the new version introduces breaking config changes
4. Consider backward compatibility for projects already using the configs

### Testing Configuration Changes

Since this package has no source code:
1. Make config changes
2. Run `composer lint:test` to verify syntax
3. Run `composer cs:test` to verify the config itself passes style checks
4. Manually test by copying configs to a real project and running tools there
