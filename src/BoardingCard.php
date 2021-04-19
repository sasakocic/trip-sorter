<?php

namespace App;

class BoardingCard
{
    /** @var string */
    private $from;
    /** @var string */
    private $to;
    /** @var string */
    private $type;
    /** @var string */
    private $number;
    /** @var string */
    private $info;

    /**
     * BoardingCard constructor.
     *
     * @param array $card
     */
    public function __construct(array $card = [])
    {
        $this->from = isset($card['from']) ? $card['from'] : '';
        $this->to = isset($card['to']) ? $card['to'] : '';
        $this->type = isset($card['type']) ? $card['type'] : '';
        $this->number = isset($card['number']) ? $card['number'] : '';
        $this->info = isset($card['info']) ? $card['info'] : '';
    }

    /**
     * Convert to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'from' => $this->getFrom(),
            'to' => $this->getTo(),
            'type' => $this->getType(),
            'number' => $this->getNumber(),
            'info' => $this->getInfo(),
        ];
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getInfo(): string
    {
        return $this->info;
    }
}
