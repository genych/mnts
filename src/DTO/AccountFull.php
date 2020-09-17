<?php declare(strict_types=1);

namespace App\DTO;

class AccountFull extends AccountShort
{
    private int $client;
    private string $balance;

    public function __construct(int $id, string $currency, int $client, string $balance)
    {
        $this->client  = $client;
        $this->balance = $balance;
        parent::__construct($id, $currency);
    }

    /**
     * @return int
     */
    public function getClient(): int
    {
        return $this->client;
    }

    /**
     * @return string
     */
    public function getBalance(): string
    {
        return $this->balance;
    }

}
