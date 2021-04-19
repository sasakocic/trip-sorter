<?php

namespace App;

/**
 * Class TripHelper.
 */
class TripHelper
{
    /**
     * @param array $cards
     *
     * @return BoardingCard[]
     */
    public static function toBoardingCards(array $cards): array
    {
        $result = [];
        foreach ($cards as $card) {
            $result[] = new BoardingCard($card);
        }

        return $result;
    }

    /**
     * @param BoardingCard[] $cards
     *
     * @return array
     */
    public static function toArray(array $cards): array
    {
        $result = [];
        foreach ($cards as $card) {
            $result[] = $card->toArray();
        }

        return $result;
    }
}
