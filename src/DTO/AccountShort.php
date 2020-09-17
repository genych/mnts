<?php declare(strict_types=1);

namespace App\DTO;

class AccountShort
{
    protected int $id;
    protected string $currency;

    /**
     * @param int    $id
     * @param string $currency
     */
    public function __construct(int $id, string $currency)
    {
        $this->id       = $id;
        $this->currency = $currency;
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
    public function getCurrency(): string
    {
        return $this->currency;
    }

}
