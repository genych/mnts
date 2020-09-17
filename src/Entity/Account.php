<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private string $currency;

    /**
     * @ORM\Column(type="integer")
     */
    private int $balance = 0;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="accounts")
     */
    private Client $client;

    /**
     * @param string $currency
     * @param Client $client
     */
    public function __construct(string $currency, Client $client)
    {
        $this->currency = $currency;
        $this->client   = $client;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
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

    /**
     * @return int
     */
    public function getBalance(): int
    {
        return $this->balance;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

}
