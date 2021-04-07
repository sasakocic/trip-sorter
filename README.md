# Trip Sorter

[![Build Status](https://img.shields.io/travis/facebook/php-graph-sdk/5.4.svg)](https://travis-ci.org/sasakocic/trip-sorter)
[![Code Style Status](https://styleci.io/repos/83059149/shield)](https://styleci.io/repos/101542570)
[![CodeCov](https://img.shields.io/codecov/c/github/sasakocic/trip-sorter.svg)](https://codecov.io/gh/sasakocic/trip-sorter)
[![CodeClimate](https://img.shields.io/codeclimate/github/sasakocic/trip-sorter.svg)](https://codeclimate.com/github/sasakocic/trip-sorter)
[![Issue Count](https://codeclimate.com/github/sasakocic/trip-sorter/badges/issue_count.svg)](https://codeclimate.com/github/sasakocic/trip-sorter)
[![Issue Count](https://scrutinizer-ci.com/g/sasakocic/trip-sorter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sasakocic/trip-sorter/?branch=master)

## Task

You are given a stack of boarding cards for various transportations that will take you from a point A to point B via several stops on the way. All of the boarding cards are out of order and you don't know where your journey starts, nor where it ends. Each boarding card contains information about seat assignment, and means of transportation (such as flight number, bus number etc).
Write an AP
I that lets you sort this kind of list and present back a description of how to complete your journey.
For instance the API should be able to take an unordered set of boarding cards, provided in a format defined by you, and produce this list:

1. Take train 78A from Madrid to Barcelona. Sit in seat 45B.
2. Take the airport bus from Barcelona to Gerona Airport. No seat assignment.
3. From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A.
Baggage drop at ticket counter 344.
4. From Stockholm, take flight SK22 to New York JFK. Gate 22, seat 7B.
Baggage will we automatically transferred from your last leg.
5. You have arrived at your final destination.

The list should be defined in a format that's compatible with the input format.
The API is to be an internal PHP API so it will only communicate with other parts of a PHP application, not server to server, nor server to client.
Use PHP-doc to document the input and output your API accepts / returns.

## Assumptions
- Since the result is only one list, I assume that input receives boarding cards for just one particular trip and we just need to sort them.
- To cover all variations of output without introducing artificial intelligence, I will assume that cards have `Sit in seat 45B.` or `No seat assignment.` written on them. Having a field seat would be considered otherwise.

## Installation

Installed with [Composer](https://getcomposer.org/). Run this command:

```sh
composer install
```

## Tests

1. The tests can be executed by running this command from the root directory:

```bash
$ php phpunit.phar
```

## Usage

Input is an array in the following format
```php
$cards = [
  ['from' => 'Madrid', 'to' => 'Barcelona', 'type' => 'train', 'number' => '78A', 'info' => 'Sit in seat 45B.'],
  ['from' => 'Barcelona', 'to' => 'Gerona Airport', 'type' => 'airport bus', 'number' => '', 'info' => 'No seat assignment.'],
  ['from' => 'Gerona Airport', 'to' => 'Stockholm', 'type' => 'flight', 'number' => 'SK455', 'seat' => '3A', 'info' => 'Gate 45B, seat 3A. Baggage drop at ticket counter 344.'],
  ['from' => 'Stockholm', 'to' => 'New York JFK', 'type' => 'flight', 'number' => 'SK455', 'seat' => '7B', 'info' => 'Gate 22. Baggage will we automatically transferred from your last leg.'],
];
$result = TripSorter::sort($cards);
```

Result is an array of strings:

1. Take train 78A from Madrid to Barcelona. Sit in seat 45B.
2. Take the airport bus from Barcelona to Gerona Airport. No seat assignment.
3. From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A.
Baggage drop at ticket counter 344.
4. From Stockholm, take flight SK22 to New York JFK. Gate 22, seat 7B.
Baggage will we automatically transferred from your last leg.
5. You have arrived at your final destination.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## License

Please see the [license file](LICENSE) for more information.
