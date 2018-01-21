<?php

namespace Richardds\ServerAdmin\Core\Cron;

use Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException;

class CronInterval
{
    /**
     * @var string
     */
    protected $minute;

    /**
     * @var string
     */
    protected $hour;

    /**
     * @var string
     */
    protected $day;

    /**
     * @var string
     */
    protected $month;

    /**
     * @var string
     */
    protected $weekday;

    /**
     * @param string $string
     * @return CronInterval
     * @throws InvalidParameterException
     */
    public static function fromString(string $string): CronInterval
    {
        $attrs = explode(' ', $string);

        if (count($attrs) != 5) {
            throw new InvalidParameterException('Invalid string interval.', [
                'string' => $string
            ]);
        }

        // TODO: Field interval validation.

        return new CronInterval($attrs[0], $attrs[1], $attrs[2], $attrs[3], $attrs[4]);
    }

    /**
     * CronInterval constructor.
     *
     * @param string $minute
     * @param string $hour
     * @param string $day
     * @param string $month
     * @param string $weekday
     */
    public function __construct(string $minute = '*', string $hour = '*', string $day = '*', string $month = '*', string $weekday = '*')
    {
        $this->minute = $minute;
        $this->hour = $hour;
        $this->day = $day;
        $this->month = $month;
        $this->weekday = $weekday;
    }

    public function setMinuteAny(): void
    {
        $this->minute = '*';
    }

    public function setHourAny(): void
    {
        $this->hour = '*';
    }

    public function setDayAny(): void
    {
        $this->day = '*';
    }

    public function setMonthAny(): void
    {
        $this->month = '*';
    }

    public function setWeekdayAny(): void
    {
        $this->weekday = '*';
    }

    /**
     * @param CronIntervalField $interval
     * @param bool $append
     * @throws InvalidParameterException
     */
    public function setMinute(CronIntervalField $interval, bool $append = false): void
    {
        if (!$interval->isValid(0, 59)) {
            throw new InvalidParameterException('Invalid minute range values. 0 <= MINUTE <= 59, FROM < TO', [
                'from' => $interval->getFrom(),
                'to' => $interval->getTo()
            ]);
        }

        $this->minute = $append && $this->minute != '*'
            ? $this->minute . ',' . (string)$interval
            : (string)$interval;
    }

    /**
     * @param CronIntervalField $interval
     * @param bool $append
     * @throws InvalidParameterException
     */
    public function setHour(CronIntervalField $interval, bool $append = false): void
    {
        if (!$interval->isValid(0, 23)) {
            throw new InvalidParameterException('Invalid hour range values. 0 <= HOUR <= 23, FROM < TO', [
                'from' => $interval->getFrom(),
                'to' => $interval->getTo()
            ]);
        }

        $this->hour = $append && $this->hour != '*'
            ? $this->hour . ',' . (string)$interval
            : (string)$interval;
    }

    /**
     * @param CronIntervalField $interval
     * @param bool $append
     * @throws InvalidParameterException
     */
    public function setDay(CronIntervalField $interval, bool $append = false): void
    {
        if (!$interval->isValid(1, 31)) {
            throw new InvalidParameterException('Invalid day range values. 1 <= DAY <= 31, FROM < TO', [
                'from' => $interval->getFrom(),
                'to' => $interval->getTo()
            ]);
        }

        $this->day = $append && $this->day != '*'
            ? $this->day . ',' . (string)$interval
            : (string)$interval;
    }

    /**
     * @param CronIntervalField $interval
     * @param bool $append
     * @throws InvalidParameterException
     */
    public function setMonth(CronIntervalField $interval, bool $append = false): void
    {
        if (!$interval->isValid(1, 12)) {
            throw new InvalidParameterException('Invalid month range values. 1 <= MONTH <= 12, FROM < TO', [
                'from' => $interval->getFrom(),
                'to' => $interval->getTo()
            ]);
        }

        $this->month = $append && $this->month != '*'
            ? $this->month . ',' . (string)$interval
            : (string)$interval;
    }

    /**
     * @param CronIntervalField $interval
     * @param bool $append
     * @throws InvalidParameterException
     */
    public function setWeekday(CronIntervalField $interval, bool $append = false): void
    {
        if (!$interval->isValid(1, 7)) {
            throw new InvalidParameterException('Invalid weekday range values. 1 <= WEEKDAY <= 7, FROM < TO', [
                'from' => $interval->getFrom(),
                'to' => $interval->getTo()
            ]);
        }

        $this->weekday = $append && $this->weekday != '*'
            ? $this->weekday . ',' . (string)$interval
            : (string)$interval;
    }

    /**
     * @param CronIntervalField[] $intervals
     * @throws InvalidParameterException
     */
    public function setMinuteList(array $intervals): void
    {
        foreach ($intervals as $interval) {
            $this->setMinute($interval, true);
        }
    }

    /**
     * @param CronIntervalField[] $intervals
     * @throws InvalidParameterException
     */
    public function setHourList(array $intervals): void
    {
        foreach ($intervals as $interval) {
            $this->setHour($interval, true);
        }
    }

    /**
     * @param CronIntervalField[] $intervals
     * @throws InvalidParameterException
     */
    public function setDayList(array $intervals): void
    {
        foreach ($intervals as $interval) {
            $this->setDay($interval, true);
        }
    }

    /**
     * @param CronIntervalField[] $intervals
     * @throws InvalidParameterException
     */
    public function setMonthList(array $intervals): void
    {
        foreach ($intervals as $interval) {
            $this->setMonth($interval, true);
        }
    }

    /**
     * @param CronIntervalField[] $intervals
     * @throws InvalidParameterException
     */
    public function setWeekdayList(array $intervals): void
    {
        foreach ($intervals as $interval) {
            $this->setWeekday($interval, true);
        }
    }

    /**
     * @param CronIntervalField $interval
     * @param int $step
     * @throws InvalidParameterException
     */
    public function setMinuteStep(CronIntervalField $interval, int $step): void
    {
        $this->setMinute($interval);
        $this->minute .= '/' . $step;
    }

    /**
     * @param CronIntervalField $interval
     * @param int $step
     * @throws InvalidParameterException
     */
    public function setHourStep(CronIntervalField $interval, int $step): void
    {
        $this->setHour($interval);
        $this->hour .= '/' . $step;
    }

    /**
     * @param CronIntervalField $interval
     * @param int $step
     * @throws InvalidParameterException
     */
    public function setDayStep(CronIntervalField $interval, int $step): void
    {
        $this->setDay($interval);
        $this->day .= '/' . $step;
    }

    /**
     * @param CronIntervalField $interval
     * @param int $step
     * @throws InvalidParameterException
     */
    public function setMonthStep(CronIntervalField $interval, int $step): void
    {
        $this->setMonth($interval);
        $this->month .= '/' . $step;
    }

    /**
     * @param CronIntervalField $interval
     * @param int $step
     * @throws InvalidParameterException
     */
    public function setWeekdayStep(CronIntervalField $interval, int $step): void
    {
        $this->setWeekday($interval);
        $this->weekday .= '/' . $step;
    }

    /**
     * @return string
     */
    public function getMinute(): string
    {
        return $this->minute;
    }

    /**
     * @return string
     */
    public function getHour(): string
    {
        return $this->hour;
    }

    /**
     * @return string
     */
    public function getDay(): string
    {
        return $this->day;
    }

    /**
     * @return string
     */
    public function getMonth(): string
    {
        return $this->month;
    }

    /**
     * @return string
     */
    public function getWeekday(): string
    {
        return $this->weekday;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->minute} {$this->hour} {$this->day} {$this->month} {$this->weekday}";
    }
}
