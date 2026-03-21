# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Dockerfile for containerized testing environment with PHP 8.3 CLI
- Automated test execution via Docker container

### Changed
- Upgraded PHP from 7.4 to 8.3 (latest LTS)
- Updated PHPUnit from ^9.5 to ^9.6
- Updated PHPCS from ^3.5 to ^3.13

### Fixed
- Removed abandoned dependencies (`codeclimate/php-test-reporter`, `sensiolabs/security-checker`)
- Resolved composer lock file inconsistencies
- Added curl dependency for Docker image

## [Initial Release] - 2026-03-21

### Added
- Trip sorter library with boarding card sorting algorithm
- TripPrinter class for formatted output generation
- Comprehensive test suite (7 tests, 7 assertions)
- PSR-12 code style compliance

### Features
- Sorts unordered boarding cards into correct journey sequence
- Handles various transportation types (train, flight, bus, etc.)
- Generates human-readable trip descriptions
- Identifies start and end points automatically
- Handles edge cases: empty input, single card, ambiguous starts
