# Changelog

All notable changes to Prologue Alerts will be documented in this file. This file follows the *[Keep a CHANGELOG](http://keepachangelog.com/)* standards.


## [0.4.3] - 2019-01-22

### Added

- docblocks;
- php 7.3 to Travis CI;

### Removed
- HHVM from Travis CI;


## [0.4.2] - 2018-02-12

### Added

- flush() method;
- Laravel package auto-discovery;


## [0.4.1] - 2017-01-24

### Added

- Laravel 5.4 support


## [0.4.0-beta.3] - 2015-03-29

### Fixed

- Moved publishes and merge config calls to correct locations

## [0.4.0-beta.2] - 2015-03-29

### Fixed

- Moved merging of config to boot method in service provider

## [0.4.0-beta.1] - 2015-03-29

### Added

- Laravel 5 support

### Changed

- Now requires PHP >=5.4
- All code converted to PSR-2
- Now using PSR-4 auto loading
- Ported Prologue's support MessageBag functionality and removed the dependency

### Removed

- Laravel 4 support

## [0.3.0] - 2014-05-23

### Added

- Add an array of messages to an alert level ([#8](https://github.com/prologuephp/alerts/issues/8))
- Get the alert levels from the MessageBag ([#7](https://github.com/prologuephp/alerts/issues/7))

## [0.2.0] - 2013-08-04

### Added

- Unit tests

### Changed

- Migrated over to Prologue Support's MessageBag class ([#2](https://github.com/prologuephp/alerts/issues/2))

### Fixed

- Some minor bug fixes

### Fixed

- Fixed a bug where only array data could be passed to the `PermissionFactory`
- Fixed a bug where a action alias got denied but was still accepted

## [0.1.1] - 2013-07-19

### Fixed

- Move config folder one folder higher ([#1](https://github.com/prologuephp/alerts/issues/1))

## [0.1.0] - 2013-07-19

First public alpha release.
