<?php

namespace App\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="`transaction`")
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Account $from_account;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Account $to_account;

    /**
     * @ORM\Column(type="integer")
     */
    private int $amount;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private string $currency;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $dt;

    /**
     * @param Account $from_account
     * @param Account $to_account
     * @param int     $amount
     * @param string  $currency
     */
    public function __construct(Account $from_account, Account $to_account, int $amount, string $currency)
    {
        $this->from_account = $from_account;
        $this->to_account   = $to_account;
        $this->amount       = $amount;
        $this->currency     = $currency;
        $this->dt           = new DateTimeImmutable('now', new DateTimeZone('utc'));
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Account
     */
    public function getFromAccount(): Account
    {
        return $this->from_account;
    }

    /**
     * @return Account
     */
    public function getToAccount(): Account
    {
        return $this->to_account;
    }

    /**
     * @return int
     */
    public function getAmount(): int
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
     * @return DateTimeInterface
     */
    public function getDt(): DateTimeInterface
    {
        return $this->dt;
    }

}
