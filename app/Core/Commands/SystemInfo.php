<?php

namespace Richardds\ServerAdmin\Core\Commands;

use Richardds\ServerAdmin\Core\Exceptions\InvalidCommandOutputException;
use Richardds\ServerAdmin\Core\Server\Memory;
use Richardds\ServerAdmin\Core\Server\Processor;
use Richardds\ServerAdmin\Core\Server\Swap;
use Richardds\ServerAdmin\Facades\Execute;

class SystemInfo
{
    /**
     * @return int
     * @throws InvalidCommandOutputException
     */
    public static function uptime(): int
    {
        $raw_output = Execute::output('cat /proc/uptime');
        $ex = explode(' ', $raw_output);

        if (2 != count($ex) || !is_numeric($ex[0])) {
            throw new InvalidCommandOutputException('Invalid command output.');
        }

        return intval(trim($ex[0]));
    }

    /**
     * @return string
     */
    public static function hostname(): string
    {
        return trim(Execute::output('hostname'));
    }

    /**
     * @return string
     * @throws InvalidCommandOutputException
     */
    public static function os(): string
    {
        $raw_output = Execute::output('lsb_release --description');
        $ex = explode(':', $raw_output);

        if (2 != count($ex)) {
            throw new InvalidCommandOutputException('Invalid command output.', $raw_output);
        }

        return trim($ex[1]);
    }

    /**
     * @return string
     */
    public static function whoami(): string
    {
        return trim(Execute::output('whoami'));
    }

    /**
     * @return Memory
     * @throws InvalidCommandOutputException
     */
    public static function memory(): Memory
    {
        $raw_output = Execute::output('free -m');
        $ex = explode(' ', regex_single($raw_output, '/Mem:(.*)\n/m'));
        $values = [];

        foreach ($ex as $i => $value) {
            if ('' != $value && is_numeric($value)) {
                $values[] = intval(trim($value));
            }
        }

        if (6 != count($values)) {
            throw new InvalidCommandOutputException('Invalid command output.', $raw_output);
        }

        return new Memory($values[0], $values[1], $values[2], $values[3], $values[4], $values[5]);
    }

    /**
     * @return Swap
     * @throws InvalidCommandOutputException
     */
    public static function swap(): Swap
    {
        $raw_output = Execute::output('free -m');
        $ex = explode(' ', regex_single($raw_output, '/Swap:(.*)\n/m'));
        $values = [];

        foreach ($ex as $i => $value) {
            if ('' != $value && is_numeric($value)) {
                $values[] = intval(trim($value));
            }
        }

        if (3 != count($values)) {
            throw new InvalidCommandOutputException('Invalid command output.', $raw_output);
        }

        return new Swap($values[0], $values[1], $values[2]);
    }

    /**
     * @return Processor
     */
    public static function processor(): Processor
    {
        $raw_output = Execute::output('cat /proc/cpuinfo');
        $model = regex_single($raw_output, '/model name\t: (.*)\n/m');
        $clock = regex_single($raw_output, '/cpu MHz\t\t: (.*)\n/m');
        $cache = regex_single($raw_output, '/cache size\t: (.*) KB\n/m');
        $cores = regex_single($raw_output, '/cpu cores\t: (.*)\n/m');
        $flags = regex_single($raw_output, '/flags\t\t: (.*)\n/m');

        return new Processor($model, $clock, $cache, $cores, $flags);
    }
}
