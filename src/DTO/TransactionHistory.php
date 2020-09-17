<?php declare(strict_types=1);

namespace App\DTO;

class TransactionHistory
{
    private int $limit;
    private int $offset;
    private int $total;
    /** @var Transaction[] */
    private array $history;

    private int   $id;

    /**
     * @param int           $id
     * @param int           $limit
     * @param int           $offset
     * @param int           $total
     * @param Transaction[] $history
     */
    public function __construct(int $id, int $limit, int $offset, int $total, array $history)
    {
        $this->id = $id;
        $this->limit   = $limit;
        $this->offset  = $offset;
        $this->total   = $total;
        $this->history = $history;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return Transaction[]
     */
    public function getHistory(): array
    {
        return $this->history;
    }

}
