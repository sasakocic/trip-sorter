<?php

namespace Test;

use Skocic\TripSorter\TripHelper;
use Skocic\TripSorter\TripPrinter;
use Skocic\TripSorter\TripSorter;
use PHPUnit\Framework\TestCase;

class TripPrinterTest extends TestCase
{
    /** @var TripSorter */
    private TripSorter $trip;
    private TripPrinter $printer;

    /**
     * Setup.
     */
    final public function setUp(): void
    {
        $this->trip = new TripSorter();
        $this->printer = new TripPrinter();
    }

    public function testOutput(): void
    {
        $cards = TripHelper::toBoardingCards([
            ['from' => 'Madrid', 'to' => 'Barcelona', 'type' => 'train', 'number' => '78A', 'info' => 'Sit in seat 45B.'],
            ['from' => 'Barcelona', 'to' => 'Gerona Airport', 'type' => 'airport bus', 'number' => '', 'info' => 'No seat assignment.'],
            ['from' => 'Gerona Airport', 'to' => 'Stockholm', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 45B, seat 3A. Baggage drop at ticket counter 344.'],
            ['from' => 'Stockholm', 'to' => 'New York JFK', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 22. Baggage will we automatically transferred from your last leg.'],
        ]);
        $expected = [
            'Take train 78A from Madrid to Barcelona. Sit in seat 45B.',
            'Take airport bus  from Barcelona to Gerona Airport. No seat assignment.',
            'From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A. Baggage drop at ticket counter 344.',
            'From Stockholm, take flight SK455 to New York JFK. Gate 22. Baggage will we automatically transferred from your last leg.',
            'You have arrived at your final destination.',
        ];
        $result = $this->trip->sort($cards);
        $this->assertSame($expected, ($this->printer)($result));
    }
}
