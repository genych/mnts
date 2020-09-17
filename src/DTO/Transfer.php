<?php declare(strict_types=1);

namespace App\DTO;

class Transfer
{
    private int $sender;
    private int $receiver;
    private string $amount;
    private string $currency;

    /**
     * @param int    $sender
     * @param int    $receiver
     * @param mixed  $amount
     * @param string $currency
     */
    public function __construct(int $sender, int $receiver, $amount, string $currency)
    {
        $this->sender   = $sender;
        $this->receiver = $receiver;
        $this->amount   = (string)$amount;
        $this->currency = $currency;
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

}
