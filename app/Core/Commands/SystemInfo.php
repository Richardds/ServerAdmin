<?php

namespace Richardds\ServerAdmin\Core\Commands;

use Richardds\ServerAdmin\Core\Exceptions\InvalidCommandOutputException;
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
            throw new InvalidCommandOutputException('Result of explode function is invalid');
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
            throw new InvalidCommandOutputException('Result of explode function is invalid');
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
}
