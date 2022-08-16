## Release notes

## [v6.0.0](https://github.com/elforastero/transliterate/releases/tag/v5.0.0-RC1)
- Minimal PHP version is now php8.0
- Support for Laravel 9
- Update dependencies
- Update Dockerfile to use php@8.0

## [v5.0.0-RC1](https://github.com/elforastero/transliterate/releases/tag/v5.0.0-RC1)
- Support for Laravel 8
- Drop support of php7.2
- Require phpunit >= 9

## [v4.0.0](https://github.com/elforastero/transliterate/releases/tag/v4.0.0)
- Support for Laravel 7

## [v3.0.0](https://github.com/elforastero/transliterate/releases/tag/v3.0.0)
- Support for Laravel 6
- Upgrade dependencies
- Update description
- Bump a major version to be able to use v2 branch with Laravel 5

## [v2.0.0](https://github.com/elforastero/transliterate/releases/tag/v2.0.0)

### Added
- Added Package Discovery support
- Added configuration file transliterate.php
- Added ability to define custom transliteration maps
- Added ability to define transformers
- Added optional removing accents using ICU
- Added tests

### Removed
- Removed all default text transformations
- Removed config option from Transliteration::make
