<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\TripSorter;

class TripSorterTest extends TestCase
{
    /** @var TripSorter */
    private $service;

    /**
     * Setup service.
     */
    public function setUp()
    {
        $this->service = new TripSorter();
    }

    /**
     * Test do method.
     */
    public function testDoWithEmpty()
    {
        $result = TripSorter::do();
        $this->assertSame(['You have arrived at your final destination.'], $result);
    }

    /**
     * Test sorting no cards.
     */
    public function testSortEmpty()
    {
        $cards = [];
        $result = $this->service->setCards($cards)->sort()->getCards();
        $this->assertSame([], $result);
    }

    /**
     * Test with only one card.
     */
    public function testSortingOneCard()
    {
        $cards = [
            ['from' => 'Madrid', 'to' => 'Barcelona', 'type' => 'train', 'number' => '78A', 'info' => 'Sit in seat 45B.'],
        ];
        $beforeSort = $this->service->setCards($cards)->getCards();
        $afterSort = $this->service->sort()->getCards();
        $this->assertSame($beforeSort, $afterSort);
    }

    /**
     * Test alread sorted cards.
     */
    public function testSorted()
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
        $result = $this->service->setCards($cards)->sort()->getCards();
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
        $result = $this->service->setCards($cards)->sort()->getCards();
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
        $result = $this->service->setCards($cards)->sort()->getCards();
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
        $result = $this->service->setCards($cards)->sort()->output();
        $this->assertSame($expected, $result);
    }
}
