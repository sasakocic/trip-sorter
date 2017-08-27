<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\TripSorter;

class TripSorterTest extends TestCase
{
    /** @var TripSorter */
    private $service;

    public function setUp()
    {
        $this->service = new TripSorter();
    }

	public function testDoWithEmpty()
	{
		$result = TripSorter::do();
		$this->assertSame(['You have arrived at your final destination.'], $result);
	}

    public function testSortEmpty()
    {
        $cards = [];
        $result = $this->service->setCards($cards)->sort()->getCards();
        $this->assertSame([], $result);
	}

    public function testSortingOneCard()
    {
        $cards = [
          ['from' => 'Madrid', 'to' => 'Barcelona', 'type' => 'train', 'number' => '78A', 'info' => 'Sit in seat 45B.'],
        ];
        $beforeSort = $this->service->setCards($cards)->getCards();
        $afterSort = $this->service->sort()->getCards();
        $this->assertSame($beforeSort, $afterSort);
	}

    public function test2()
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
