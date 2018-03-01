<?php

namespace Richardds\ServerAdmin\Core\Server;

class Memory
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
     * @var int
     */
    private $shared;

    /**
     * @var int
     */
    private $cache;

    /**
     * @var int
     */
    private $available;

    /**
     * Memory constructor.
     * @param int $total
     * @param int $used
     * @param int $free
     * @param int $shared
     * @param int $cache
     * @param int $available
     */
    public function __construct(int $total, int $used, int $free, int $shared, int $cache, int $available)
    {
        $this->total = $total;
        $this->used = $used;
        $this->free = $free;
        $this->shared = $shared;
        $this->cache = $cache;
        $this->available = $available;
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
     * @return int
     */
    public function getShared(): int
    {
        return $this->shared;
    }

    /**
     * @param int $shared
     */
    public function setShared(int $shared): void
    {
        $this->shared = $shared;
    }

    /**
     * @return int
     */
    public function getCache(): int
    {
        return $this->cache;
    }

    /**
     * @param int $cache
     */
    public function setCache(int $cache): void
    {
        $this->cache = $cache;
    }

    /**
     * @return int
     */
    public function getAvailable(): int
    {
        return $this->available;
    }

    /**
     * @return float
     */
    public function getAvailablePercentage(): float
    {
        return ($this->total - $this->available) / $this->total * 100;
    }

    /**
     * @param int $available
     */
    public function setAvailable(int $available): void
    {
        $this->available = $available;
    }

}
