<?php

namespace Richardds\ServerAdmin\Facades;

use Illuminate\Support\Facades\Facade;
use Richardds\ServerAdmin\Core\CommandExecuter;

/**
 * @method static output(string $command, bool $superuser = false)
 * @method static executeWithoutOutput(string $command, bool $superuser = false)
 */
class Command extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CommandExecuter::class;
    }
}
