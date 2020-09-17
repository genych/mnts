<?php declare(strict_types=1);

namespace App\DTO;

class Client
{
    private int $id;
    /** @var AccountShort[] */
    private array $accounts;
    private ClientInfo $info;

    /**
     * @param int            $id
     * @param AccountShort[] $accounts
     * @param ClientInfo     $info
     */
    public function __construct(int $id, array $accounts, ClientInfo $info)
    {
        $this->id       = $id;
        $this->accounts = $accounts;
        $this->info     = $info;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return AccountShort[]
     */
    public function getAccounts(): array
    {
        return $this->accounts;
    }

    /**
     * @return ClientInfo
     */
    public function getInfo(): ClientInfo
    {
        return $this->info;
    }

}
