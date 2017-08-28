<?php

namespace App;

/**
 * Class for working with Trips.
 */
class TripSorter
{
    /** @var BoardingCard[] */
    private $cards;

    /**
     * TripSorter constructor.
     *
     * @param BoardingCard[] $cards
     */
    public function __construct(array $cards = [])
    {
        $this->setCards($cards);
    }

    /**
     * @return array
     */
    public function getCards()
    {
        $cards = [];
        foreach ($this->cards as $card) {
            $cards[] = $card->toArray();
        }

        return $cards;
    }

    /**
     * @param BoardingCard[] $cards
     *
     * @return TripSorter
     */
    public function setCards(array $cards = [])
    {
        $this->cards = [];
        foreach ($cards as $card) {
            $this->cards[] = new BoardingCard($card);
        }

        return $this;
    }

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
     * $result = TripSorter::do($cards);
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
     * @param array $cards
     *
     * @static
     * @return array
     */
    public static function sort(array $cards = [])
    {
        $instance = new self($cards);
        $instance->sortCards();
        $result = $instance->output();

        return $result;
    }

    /**
     * Sorts the boarding cards.
     */
    public function sortCards()
    {
        $count = 0;
        $fromCity = [];
        $toCity = [];
        foreach ($this->cards as $card) {
            $toCity[$card->getTo()] = $count;
            $fromCity[$card->getFrom()] = $count++;
        }
        if (empty($fromCity)) {
            return $this;
        }
        $diff = array_keys(array_diff_key($fromCity, $toCity));
        if (count($diff) !== 1) {
            throw new \RuntimeException('There should be one starting point');
        }
        $city = $diff[0];
        $sorted = [];
        while (isset($fromCity[$city])) {
            $index = $fromCity[$city];
            $sorted[] = $this->cards[$index];
            $city = $this->cards[$index]->getTo(); // Barcelona
        }
        $this->cards = $sorted;

        return $this;
    }

    /**
     * Formats the output.
     *
     * @return array
     */
    public function output()
    {
        $output = [];
        foreach ($this->cards as $card) {
            if ($card->getType() === 'flight') {
                $output[] = 'From ' . $card->getFrom()
                    . ', take ' . $card->getType()
                    . ' ' . $card->getNumber()
                    . ' to ' . $card->getTo()
                    . '. ' . $card->getInfo();
            } else {
                $output[] = 'Take ' . $card->getType()
                    . ' ' . $card->getNumber()
                    . ' from ' . $card->getFrom()
                    . ' to ' . $card->getTo()
                    . '. ' . $card->getInfo();
            }
        }
        $output[] = 'You have arrived at your final destination.';

        return $output;
    }
}
