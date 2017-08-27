<?php

namespace App;

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
     * @param array $cards
     *
     * @static
     * @return array
     */
    public static function do(array $cards = [])
    {
        $instance = new self($cards);
        $instance->sort();
        $result = $instance->output();

        return $result;
    }

    /**
     * Sorts the boarding cards.
     */
    public function sort()
    {
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
