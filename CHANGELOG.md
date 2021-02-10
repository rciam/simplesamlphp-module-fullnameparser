# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [v3.1.2] - 2021-02-10

### Fixed

- Logger namespace

## [v3.1.1] - 2021-02-08

### Added

- Add `replace` configuration option to `GenerateFullName` processing filter

## [v3.1.0] - 2020-11-17
🌹

### Added

- Add `GenerateFullName` processing filter

## [v3.0.0] - 2019-09-05

This version is compatible with [SimpleSAMLphp v1.17](https://simplesamlphp.org/docs/1.17/simplesamlphp-changelog)

### Changed

- Code reformatted based on PSR-2
- Declare module's class under SimpleSAML\Module namespace

## [v2.0.0] - 2019-07-26

This version is compatible with [SimpleSAMLphp v1.15](https://simplesamlphp.org/docs/1.15/simplesamlphp-changelog)

### Added

- Support for SimpleSAMLphp version 1.15

## [v1.1.0] - 2019-07-25

### Added

- Support for parsing email address

### Fixed

- Fix check of existing first/last name information in user attributes based on configured attribute names

## [v1.0.1] - 2019-07-18

### Fixed

- Fix class names

## [v1.0.0] - 2019-07-17

This version is compatible with [SimpleSAMLphp v1.14](https://simplesamlphp.org/docs/1.14/simplesamlphp-changelog)

### Added

- FullNameParser library
  - PHP library to split names into their respective components (first, last, etc)
- FullNameParsing class
  - Module class that uses the library
