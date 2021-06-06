# fox91 PHP Dev Tools

[![Latest version](https://img.shields.io/packagist/v/fox91/dev-tools.svg?colorB=007EC6)](https://packagist.org/packages/fox91/dev-tools)
[![Downloads](https://img.shields.io/packagist/dt/fox91/dev-tools.svg?colorB=007EC6)](https://packagist.org/packages/fox91/dev-tools)
[![Build status](https://github.com/fox91/php-dev-tools/workflows/php-ci/badge.svg?branch=main)](https://github.com/fox91/php-dev-tools/actions?query=workflow%3Aphp-ci+branch%3Amain)

Compatible with PHP `7.3`, `7.4` and `8.0`.

## Included tools

- PHP Parallel Lint
- PHP_CodeSniffer
    + `dealerdirect/phpcodesniffer-composer-installer`
    + `fox91/coding-standard`
- PHPStan
    + `brainbits/phpstan-rules`
    + `ergebnis/phpstan-rules`
    + `ikvasnica/phpstan-clean-test`
    + `korbeil/phpstan-generic-rules`
    + `phpstan/extension-installer`
    + `phpstan/phpstan-beberlei-assert`
    + `phpstan/phpstan-deprecation-rules`
    + `phpstan/phpstan-phpunit`
    + `phpstan/phpstan-strict-rules`
- PHPUnit
- Psalm
    + `psalm/plugin-phpunit`
- Rector

## Installation

```bsh
composer require --dev fox91/dev-tools
```

### Config example

Add following code to your `composer.json`:

```json
"scripts": {
    "cs:fix": "phpcbf --colors",
    "cs:test": "phpcs --colors",
    "lint:test": "parallel-lint --no-progress --blame --exclude vendor .",
    "phpstan:test": "phpstan analyse --no-progress --ansi --memory-limit 128M",
    "psalm:test": "psalm --no-progress --stats --show-info=true --show-snippet",
    "rector:fix": "rector --ansi process --no-progress-bar",
    "rector:test": "rector --ansi process --dry-run --no-progress-bar",
    "unit:test": "phpunit",
    "fix": [
        "@rector:fix",
        "@cs:fix"
    ],
    "test": [
        "@lint:test",
        "@rector:test",
        "@cs:test",
        "@phpstan:test",
        "@psalm:test",
        "@unit:test"
    ]
},
"scripts-descriptions": {
    "cs:fix": "Run PHP_CodeSniffer fixes",
    "cs:test": "Run PHP_CodeSniffer tests",
    "fix": "Run all fixes!",
    "lint:test": "Run PHP Parallel Lint tests",
    "phpstan:test": "Run PHPStan tests",
    "psalm:test": "Run Psalm tests",
    "rector:fix": "Run Rector fixes",
    "rector:test": "Run Rector tests",
    "test": "Run all tests!",
    "unit:test": "Run PHPUnit tests"
}
```

Copy default configs to the root of your project:

```sh
cp \
  vendor/fox91/dev-tools/configs/.editorconfig \
  vendor/fox91/dev-tools/configs/gitattributes.txt \
  vendor/fox91/dev-tools/configs/.gitignore \
  vendor/fox91/dev-tools/configs/.phpcs.xml.dist \
  vendor/fox91/dev-tools/configs/phpstan.neon.dist \
  vendor/fox91/dev-tools/configs/psalm.xml.dist \
  vendor/fox91/dev-tools/configs/rector.php \
  .
mv gitattributes.txt .gitattributes
```
