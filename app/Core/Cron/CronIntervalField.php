<?php

namespace Richardds\ServerAdmin\Core\Cron;

class CronIntervalField
{
    /**
     * @var int
     */
    protected $from;

    /**
     * @var int|null
     */
    protected $to;

    /**
     * @param int $number
     * @return CronIntervalField
     */
    public static function single(int $number): CronIntervalField
    {
        return new CronIntervalField($number);
    }

    /**
     * @param int $from
     * @param int $to
     * @return CronIntervalField
     */
    public static function range(int $from, int $to): CronIntervalField
    {
        return new CronIntervalField($from, $to);
    }

    /**
     * CronFieldInterval constructor.
     * @param int $from
     * @param int|null $to
     */
    private function __construct(int $from, ?int $to = null)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return int
     */
    public function getFrom(): int
    {
        return $this->from;
    }

    /**
     * @param int $from
     */
    public function setFrom(int $from): void
    {
        $this->from = $from;
    }

    /**
     * @return int|null
     */
    public function getTo(): ?int
    {
        return $this->to;
    }

    /**
     * @param int|null $to
     */
    public function setTo(?int $to): void
    {
        $this->to = $to;
    }

    /**
     * @param int $min
     * @param int $max
     * @return bool
     */
    public function isValid(int $min, int $max): bool
    {
        if (is_null($this->to)) {
            return ($min <= $this->from && $this->from <= $max);
        } else {
            $fromValid = ($min <= $this->from && $this->from <= $max);
            $toValid = ($min <= $this->to && $this->to <= $max);

            return $fromValid && $toValid && $this->from < $this->to;
        }
    }

    /**
     * @return bool
     */
    public function isRange(): bool
    {
        return !is_null($this->to);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return is_null($this->to) ? (string)$this->from : $this->from . '-' . $this->to;
    }
}
