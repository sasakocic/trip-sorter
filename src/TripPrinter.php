<?php

namespace App;

class TripPrinter
{
    /**
     * @param BoardingCard[] $cards
     * @return array
     */
    public function __invoke(array $cards): array
    {
        $output = [];
        foreach ($cards as $card) {
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
