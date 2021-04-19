<?php

namespace App;

class TripSorter
{
    /**
     * Sort an array of trip cards.
     *
     * Example:
     * $cards = [
     *   ['from' => 'Madrid', 'to' => 'Barcelona', 'type' => 'train', 'number' => '78A', 'info' => 'Sit in seat 45B.'],
     *   ['from' => 'Barcelona', 'to' => 'Gerona Airport', 'type' => 'airport bus', 'number' => '', 'info' => 'No seat assignment.'],
     *   ['from' => 'Gerona Airport', 'to' => 'Stockholm', 'type' => 'flight', 'number' => 'SK455', 'seat' => '3A', 'info' => 'Gate 45B, seat 3A. Baggage drop at ticket counter 344.'],
     *   ['from' => 'Stockholm', 'to' => 'New York JFK', 'type' => 'flight', 'number' => 'SK455', 'seat' => '7B', 'info' => 'Gate 22. Baggage will we automatically transferred from your last leg.'],
     * ];
     * $result = TripSorter::sort($cards);
     *
     * returns
     * [
     *     'Take train 78A from Madrid to Barcelona. Sit in seat 45B.',
     *     'Take airport bus  from Barcelona to Gerona Airport. No seat assignment.',
     *     'From Gerona Airport, take flight SK455 to Stockholm. Gate 45B, seat 3A. Baggage drop at ticket counter 344.',
     *     'From Stockholm, take flight SK455 to New York JFK. Gate 22. Baggage will we automatically transferred from your last leg.',
     *     'You have arrived at your final destination.',
     * ];
     *
     * @param BoardingCard[] $cards
     *
     * @return BoardingCard[]
     */
    public function sort(array $cards = []): array
    {
        $count = 0;
        $fromCity = [];
        $toCity = [];
        foreach ($cards as $card) {
            $toCity[$card->getTo()] = $count;
            $fromCity[$card->getFrom()] = $count++;
        }
        if (empty($fromCity)) {
            return [];
        }
        $diff = array_keys(array_diff_key($fromCity, $toCity));
        if (count($diff) !== 1) {
            throw new TripException('There should be one starting point');
        }
        $city = $diff[0];
        $sorted = [];
        while (isset($fromCity[$city])) {
            $index = $fromCity[$city];
            $sorted[] = $cards[$index];
            $city = $cards[$index]->getTo(); // Barcelona
        }

        return $sorted;
    }
}
