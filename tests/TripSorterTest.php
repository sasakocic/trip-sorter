<?php

namespace Test;

use Skocic\TripSorter\TripHelper;
use Skocic\TripSorter\TripPrinter;
use Skocic\TripSorter\TripSorter;
use PHPUnit\Framework\TestCase;

class TripSorterTest extends TestCase
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

    /**
     * Test do method.
     */
    final public function testDoWithEmpty(): void
    {
        $result = $this->trip->sort();
        $this->assertSame(['You have arrived at your final destination.'], ($this->printer)($result));
    }

    /**
     * Test sorting no cards.
     */
    final public function testSortEmpty(): void
    {
        $cards = [];
        $result = $this->trip->sort($cards);
        $this->assertSame([], $result);
    }

    /**
     * Test with only one card.
     */
    final public function testSortingOneCard(): void
    {
        $cards = [
            ['from' => 'Madrid', 'to' => 'Barcelona', 'type' => 'train', 'number' => '78A', 'info' => 'Sit in seat 45B.'],
        ];
        $boardingCards = TripHelper::toBoardingCards($cards);
        $afterSort = $this->trip->sort($boardingCards);
        $this->assertSame($boardingCards, $afterSort);
    }

    /**
     * Test alread sorted cards.
     */
    final public function testSorted(): void
    {
        $cards = [
            ['from' => 'Madrid', 'to' => 'Barcelona', 'type' => 'train', 'number' => '78A', 'info' => 'Sit in seat 45B.'],
            ['from' => 'Barcelona', 'to' => 'Gerona Airport', 'type' => 'airport bus', 'number' => '', 'info' => 'No seat assignment.'],
            ['from' => 'Gerona Airport', 'to' => 'Stockholm', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 45B, seat 3A. Baggage drop at ticket counter 344.'],
            ['from' => 'Stockholm', 'to' => 'New York JFK', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 22. Baggage will we automatically transferred from your last leg.'],
        ];
        $expected = [
            ['from' => 'Madrid', 'to' => 'Barcelona', 'type' => 'train', 'number' => '78A', 'info' => 'Sit in seat 45B.'],
            ['from' => 'Barcelona', 'to' => 'Gerona Airport', 'type' => 'airport bus', 'number' => '', 'info' => 'No seat assignment.'],
            ['from' => 'Gerona Airport', 'to' => 'Stockholm', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 45B, seat 3A. Baggage drop at ticket counter 344.'],
            ['from' => 'Stockholm', 'to' => 'New York JFK', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 22. Baggage will we automatically transferred from your last leg.'],
        ];
        $result = $this->trip->sort(TripHelper::toBoardingCards($cards));
        $this->assertSame($expected, TripHelper::toArray($result));
    }

    /**
     * Test unsorted cards.
     */
    public function testUnsorted()
    {
        $cards = TripHelper::toBoardingCards([
            ['from' => 'Stockholm', 'to' => 'New York JFK', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 22. Baggage will we automatically transferred from your last leg.'],
            ['from' => 'Barcelona', 'to' => 'Gerona Airport', 'type' => 'airport bus', 'number' => '', 'info' => 'No seat assignment.'],
            ['from' => 'Madrid', 'to' => 'Barcelona', 'type' => 'train', 'number' => '78A', 'info' => 'Sit in seat 45B.'],
            ['from' => 'Gerona Airport', 'to' => 'Stockholm', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 45B, seat 3A. Baggage drop at ticket counter 344.'],
        ]);
        $expected = [
            ['from' => 'Madrid', 'to' => 'Barcelona', 'type' => 'train', 'number' => '78A', 'info' => 'Sit in seat 45B.'],
            ['from' => 'Barcelona', 'to' => 'Gerona Airport', 'type' => 'airport bus', 'number' => '', 'info' => 'No seat assignment.'],
            ['from' => 'Gerona Airport', 'to' => 'Stockholm', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 45B, seat 3A. Baggage drop at ticket counter 344.'],
            ['from' => 'Stockholm', 'to' => 'New York JFK', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 22. Baggage will we automatically transferred from your last leg.'],
        ];
        $result = $this->trip->sort($cards);
        $this->assertSame($expected, TripHelper::toArray($result));
    }

    public function testWithAmbigiousStart()
    {
        $cards = TripHelper::toBoardingCards([
            ['from' => 'Stockholm', 'to' => 'New York JFK', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 22. Baggage will we automatically transferred from your last leg.'],
            ['from' => 'Madrid', 'to' => 'Barcelona', 'type' => 'train', 'number' => '78A', 'info' => 'Sit in seat 45B.'],
            ['from' => 'Gerona Airport', 'to' => 'Stockholm', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 45B, seat 3A. Baggage drop at ticket counter 344.'],
        ]);
        $expected = [
            ['from' => 'Madrid', 'to' => 'Barcelona', 'type' => 'train', 'number' => '78A', 'info' => 'Sit in seat 45B.'],
            ['from' => 'Barcelona', 'to' => 'Gerona Airport', 'type' => 'airport bus', 'number' => '', 'info' => 'No seat assignment.'],
            ['from' => 'Gerona Airport', 'to' => 'Stockholm', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 45B, seat 3A. Baggage drop at ticket counter 344.'],
            ['from' => 'Stockholm', 'to' => 'New York JFK', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 22. Baggage will we automatically transferred from your last leg.'],
        ];
        $this->expectExceptionMessage('There should be one starting point');
        $result = $this->trip->sort($cards);
    }
}
