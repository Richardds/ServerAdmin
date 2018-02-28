<?php

namespace Richardds\ServerAdmin\Core\Server;

use Carbon\Carbon;

class Uptime
{
    /**
     * @var int
     */
    private $seconds;

    /**
     * Uptime constructor.
     * @param int $seconds
     */
    public function __construct(int $seconds)
    {
        $this->seconds = $seconds;
    }

    /**
     * @return int
     */
    public function getSecondPart(): int
    {
        return floor($this->seconds % 60);
    }

    /**
     * @return int
     */
    public function getSeconds(): int
    {
        return $this->seconds;
    }

    /**
     * @return int
     */
    public function getMinutePart(): int
    {
        return floor($this->seconds / 60 % 60);
    }

    /**
     * @return int
     */
    public function getMinutes(): int
    {
        return floor($this->seconds / 60);
    }

    /**
     * @return int
     */
    public function getHourPart(): int
    {
        return floor($this->seconds / 3600 % 24);
    }

    /**
     * @return int
     */
    public function getHours(): int
    {
        return floor($this->seconds / 3600);
    }

    /**
     * @return int
     */
    public function getDayPart(): int
    {
        return floor($this->seconds / 86400);
    }

    /**
     * @return int
     */
    public function getDays(): int
    {
        return floor($this->seconds / 86400);
    }

    /**
     * @return Carbon
     */
    public function getLastOffline(): Carbon
    {
        return Carbon::now()->subSeconds($this->seconds);
    }
}
