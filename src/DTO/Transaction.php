<?php declare(strict_types=1);

namespace App\DTO;

class Transaction
{
    private int $id;
    private string $amount;
    private string $currency;
    private int $sender;
    private int $receiver;
    private string $datetime;

    public function __construct(int $id, string $amount, string $currency, int $sender, int $receiver, string $datetime)
    {
        $this->id       = $id;
        $this->amount   = $amount;
        $this->currency = $currency;
        $this->sender   = $sender;
        $this->receiver = $receiver;
        $this->datetime = $datetime;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getSender(): int
    {
        return $this->sender;
    }

    /**
     * @return int
     */
    public function getReceiver(): int
    {
        return $this->receiver;
    }

    /**
     * @return string
     */
    public function getDatetime(): string
    {
        return $this->datetime;
    }

}
