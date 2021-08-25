# fox91 PHP Dev Tools

[![Latest version](https://img.shields.io/packagist/v/fox91/dev-tools.svg?colorB=007EC6)](https://packagist.org/packages/fox91/dev-tools)
[![Downloads](https://img.shields.io/packagist/dt/fox91/dev-tools.svg?colorB=007EC6)](https://packagist.org/packages/fox91/dev-tools)
[![Build status](https://github.com/fox91/php-dev-tools/workflows/php-ci/badge.svg?branch=main)](https://github.com/fox91/php-dev-tools/actions?query=workflow%3Aphp-ci+branch%3Amain)

Compatible with PHP `7.3`, `7.4` and `8.0`.

## Included tools

- [PHP Parallel Lint](https://packagist.org/packages/php-parallel-lint/php-parallel-lint)
- [PHP_CodeSniffer](https://packagist.org/packages/squizlabs/php_codesniffer)
    + [`dealerdirect/phpcodesniffer-composer-installer`](https://packagist.org/packages/dealerdirect/phpcodesniffer-composer-installer)
    + [`fox91/coding-standard`](https://packagist.org/packages/fox91/coding-standard)
- [PHPUnit](https://packagist.org/packages/phpunit/phpunit)
- [Psalm](https://packagist.org/packages/vimeo/psalm)
    + [`psalm/plugin-phpunit`](https://packagist.org/packages/psalm/plugin-phpunit)
- [Rector](https://packagist.org/packages/rector/rector)

## Optional tools

- [PHPStan](https://packagist.org/packages/phpstan/phpstan)
    + [`brainbits/phpstan-rules`](https://packagist.org/packages/brainbits/phpstan-rules)
    + [`ergebnis/phpstan-rules`](https://packagist.org/packages/ergebnis/phpstan-rules)
    + [`ikvasnica/phpstan-clean-test`](https://packagist.org/packages/ikvasnica/phpstan-clean-test)
    + [`korbeil/phpstan-generic-rules`](https://packagist.org/packages/korbeil/phpstan-generic-rules)
    + [`phpstan/extension-installer`](https://packagist.org/packages/phpstan/extension-installer)
    + [`phpstan/phpstan-beberlei-assert`](https://packagist.org/packages/phpstan/phpstan-beberlei-assert)
    + [`phpstan/phpstan-deprecation-rules`](https://packagist.org/packages/phpstan/phpstan-deprecation-rules)
    + [`phpstan/phpstan-phpunit`](https://packagist.org/packages/phpstan/phpstan-phpunit)
    + [`phpstan/phpstan-strict-rules`](https://packagist.org/packages/phpstan/phpstan-strict-rules)

## Installation

```bash
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

```bash
cp \
  vendor/fox91/dev-tools/configs/.editorconfig \
  vendor/fox91/dev-tools/configs/.gitignore \
  vendor/fox91/dev-tools/configs/.phpcs.xml.dist \
  vendor/fox91/dev-tools/configs/gitattributes.txt \
  vendor/fox91/dev-tools/configs/phpdoc.dist.xml \
  vendor/fox91/dev-tools/configs/phpstan.neon.dist \
  vendor/fox91/dev-tools/configs/phpunit.xml.dist \
  vendor/fox91/dev-tools/configs/psalm.xml.dist \
  vendor/fox91/dev-tools/configs/rector.php \
  .
mv gitattributes.txt .gitattributes
```

## Usage

```bash
composer test
docker run --rm -v "$(pwd)":/data:rw phpdoc/phpdoc run
```
