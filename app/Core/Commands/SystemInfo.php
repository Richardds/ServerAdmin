<?php

namespace Richardds\ServerAdmin\Core\Commands;

use Richardds\ServerAdmin\Core\Exceptions\InvalidCommandOutputException;
use Richardds\ServerAdmin\Facades\Execute;

class SystemInfo
{
    public static function uptime()
    {
        $raw_output = Execute::output('cat /proc/uptime');
        $ex = explode(' ', $raw_output);

        if (2 != count($ex) || !is_numeric($ex[0])) {
            throw new InvalidCommandOutputException('Result of explode function is invalid');
        }

        return intval($ex[0]);
    }

    public static function hostname()
    {
        return Execute::output('hostname');
    }

    public static function os()
    {
        $raw_output = Execute::output('lsb_release --description');
        $ex = explode(':', $raw_output);

        if (2 != count($ex)) {
            throw new InvalidCommandOutputException('Result of explode function is invalid');
        }

        return trim($ex[1]);
    }
}
