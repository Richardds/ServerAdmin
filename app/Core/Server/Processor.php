<?php

namespace Richardds\ServerAdmin\Core\Server;

class Processor
{
    /**
     * @var string
     */
    private $model;

    /**
     * @var int
     */
    private $clock;

    /**
     * @var int
     */
    private $cache;

    /**
     * @var int
     */
    private $cores;

    /**
     * @var string
     */
    private $flags;

    /**
     * Processor constructor.
     * @param string $model
     * @param int $clock
     * @param int $cache
     * @param int $cores
     * @param string $flags
     */
    public function __construct(string $model, int $clock, int $cache, int $cores, string $flags)
    {
        $this->model = $model;
        $this->clock = $clock;
        $this->cache = $cache;
        $this->cores = $cores;
        $this->flags = $flags;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    /**
     * @return int
     */
    public function getClock(): int
    {
        return $this->clock;
    }

    /**
     * @param int $clock
     */
    public function setClock(int $clock): void
    {
        $this->clock = $clock;
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
    public function getCores(): int
    {
        return $this->cores;
    }

    /**
     * @param int $cores
     */
    public function setCores(int $cores): void
    {
        $this->cores = $cores;
    }

    /**
     * @return string
     */
    public function getFlags(): string
    {
        return $this->flags;
    }

    /**
     * @param string $flags
     */
    public function setFlags(string $flags): void
    {
        $this->flags = $flags;
    }
}
