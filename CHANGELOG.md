# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

##[Unreleased]

###Added

- Support for parsing email address

### Fixed

- Fix attribute names in the condition of FullNameParsing class

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
