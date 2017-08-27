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
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     *
     * @return BoardingCard
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     *
     * @return BoardingCard
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return BoardingCard
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     *
     * @return BoardingCard
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return string
     */
    public function getInfo(): string
    {
        return $this->info;
    }

    /**
     * @param string $info
     *
     * @return BoardingCard
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Convert to array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'from' => $this->getFrom(),
            'to' => $this->getTo(),
            'type' => $this->getType(),
            'number' => $this->getNumber(),
            'info' => $this->getInfo(),
        ];
    }
}
