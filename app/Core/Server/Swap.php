<?php

namespace Richardds\ServerAdmin\Core\Server;

class Swap
{
    /**
     * @var int
     */
    private $total;

    /**
     * @var int
     */
    private $used;

    /**
     * @var int
     */
    private $free;

    /**
     * Memory constructor.
     * @param int $total
     * @param int $used
     * @param int $free
     */
    public function __construct(int $total, int $used, int $free)
    {
        $this->total = $total;
        $this->used = $used;
        $this->free = $free;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getUsed(): int
    {
        return $this->used;
    }

    /**
     * @param int $used
     */
    public function setUsed(int $used): void
    {
        $this->used = $used;
    }

    /**
     * @return int
     */
    public function getFree(): int
    {
        return $this->free;
    }

    /**
     * @param int $free
     */
    public function setFree(int $free): void
    {
        $this->free = $free;
    }

    /**
     * @return float
     */
    public function getAvailablePercentage(): float
    {
        return ($this->total - $this->free) / $this->total * 100;
    }

}
