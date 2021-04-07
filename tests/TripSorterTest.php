<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use App\TripSorter;

class TripSorterTest extends TestCase
{
    /** @var TripSorter */
    private $service;

    /**
     * Setup service.
     */
    final public function setUp(): void
    {
        $this->service = new TripSorter();
    }

    /**
     * Test do method.
     */
    final public function testDoWithEmpty(): void
    {
        $result = TripSorter::sort();
        $this->assertSame(['You have arrived at your final destination.'], $result);
    }

    /**
     * Test sorting no cards.
     */
    final public function testSortEmpty(): void
    {
        $cards = [];
        $result = $this->service->setCards($cards)->sortCards()->getCards();
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
        $beforeSort = $this->service->setCards($cards)->getCards();
        $afterSort = $this->service->sortCards()->getCards();
        $this->assertSame($beforeSort, $afterSort);
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
        $result = $this->service->setCards($cards)->sortCards()->getCards();
        $this->assertSame($expected, $result);
    }

    /**
     * Test unsorted cards.
     */
    public function testUnsorted()
    {
        $cards = [
            ['from' => 'Stockholm', 'to' => 'New York JFK', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 22. Baggage will we automatically transferred from your last leg.'],
            ['from' => 'Barcelona', 'to' => 'Gerona Airport', 'type' => 'airport bus', 'number' => '', 'info' => 'No seat assignment.'],
            ['from' => 'Madrid', 'to' => 'Barcelona', 'type' => 'train', 'number' => '78A', 'info' => 'Sit in seat 45B.'],
            ['from' => 'Gerona Airport', 'to' => 'Stockholm', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 45B, seat 3A. Baggage drop at ticket counter 344.'],
        ];
        $expected = [
            ['from' => 'Madrid', 'to' => 'Barcelona', 'type' => 'train', 'number' => '78A', 'info' => 'Sit in seat 45B.'],
            ['from' => 'Barcelona', 'to' => 'Gerona Airport', 'type' => 'airport bus', 'number' => '', 'info' => 'No seat assignment.'],
            ['from' => 'Gerona Airport', 'to' => 'Stockholm', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 45B, seat 3A. Baggage drop at ticket counter 344.'],
            ['from' => 'Stockholm', 'to' => 'New York JFK', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 22. Baggage will we automatically transferred from your last leg.'],
        ];
        $result = $this->service->setCards($cards)->sortCards()->getCards();
        $this->assertSame($expected, $result);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage There should be one starting point
     */
    public function testWithAmbigiousStart()
    {
        $cards = [
            ['from' => 'Stockholm', 'to' => 'New York JFK', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 22. Baggage will we automatically transferred from your last leg.'],
            ['from' => 'Madrid', 'to' => 'Barcelona', 'type' => 'train', 'number' => '78A', 'info' => 'Sit in seat 45B.'],
            ['from' => 'Gerona Airport', 'to' => 'Stockholm', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 45B, seat 3A. Baggage drop at ticket counter 344.'],
        ];
        $expected = [
            ['from' => 'Madrid', 'to' => 'Barcelona', 'type' => 'train', 'number' => '78A', 'info' => 'Sit in seat 45B.'],
            ['from' => 'Barcelona', 'to' => 'Gerona Airport', 'type' => 'airport bus', 'number' => '', 'info' => 'No seat assignment.'],
            ['from' => 'Gerona Airport', 'to' => 'Stockholm', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 45B, seat 3A. Baggage drop at ticket counter 344.'],
            ['from' => 'Stockholm', 'to' => 'New York JFK', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 22. Baggage will we automatically transferred from your last leg.'],
        ];
        $this->expectExceptionMessage('There should be one starting point');
        $result = $this->service->setCards($cards)->sortCards()->getCards();
        $this->assertSame($expected, $result);
    }

    public function testOutput()
    {
        $cards = [
            ['from' => 'Madrid', 'to' => 'Barcelona', 'type' => 'train', 'number' => '78A', 'info' => 'Sit in seat 45B.'],
            ['from' => 'Barcelona', 'to' => 'Gerona Airport', 'type' => 'airport bus', 'number' => '', 'info' => 'No seat assignment.'],
            ['from' => 'Gerona Airport', 'to' => 'Stockholm', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 45B, seat 3A. Baggage drop at ticket counter 344.'],
            ['from' => 'Stockholm', 'to' => 'New York JFK', 'type' => 'flight', 'number' => 'SK455', 'info' => 'Gate 22. Baggage will we automatically transferred from your last leg.'],
        ];
        $expected = [
            'Take train 78A from Madrid to Barcelona. Sit in seat 45B.',
            'Take airport bus  from Barcelona to Gerona Airport. No seat assignment.',
            'From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A. Baggage drop at ticket counter 344.',
            'From Stockholm, take flight SK455 to New York JFK. Gate 22. Baggage will we automatically transferred from your last leg.',
            'You have arrived at your final destination.',
        ];
        $result = $this->service->setCards($cards)->sortCards()->output();
        $this->assertSame($expected, $result);
    }
}
