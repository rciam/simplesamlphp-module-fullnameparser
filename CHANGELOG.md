# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [v1.2.1] - 2020-04-23

### Changed

- Improve class documentation

### Fixed

- Fix closing bracket error

## [v1.2.0] - 2020-04-23

### Added

- Add GenerateFullName authproc filter for generating the user's full name based on the available given name and surname information

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
