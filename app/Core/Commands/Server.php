<?php

namespace Richardds\ServerAdmin\Core\Commands;

use Richardds\ServerAdmin\Facades\Execute;

class Server
{
    /**
     * @return void
     */
    public static function stop(): void
    {
        Execute::withoutOutput('shutdown now', true);
    }

    /**
     * @return void
     */
    public static function restart(): void
    {
        Execute::withoutOutput('reboot', true);
    }
}
