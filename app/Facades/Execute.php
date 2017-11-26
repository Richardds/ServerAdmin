<?php

namespace Richardds\ServerAdmin\Facades;

use Illuminate\Support\Facades\Facade;
use Richardds\ServerAdmin\Core\CommandExecuter;

/**
 * @method static output(string $command, bool $superuser = false)
 * @method static withoutOutput(string $command, bool $superuser = false)
 */
class Execute extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CommandExecuter::class;
    }
}
