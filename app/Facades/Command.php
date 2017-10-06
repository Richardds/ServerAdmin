<?php

namespace Richardds\ServerAdmin\Facades;

use Illuminate\Support\Facades\Facade;
use Richardds\ServerAdmin\Core\CommandExecuter;

/**
 * @method static create(string $command)
 * @method static execute(string $command, callable $callback = null)
 * @method static output(string $command)
 * @method static executeWithoutOutput(string $command)
 */
class Command extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CommandExecuter::class;
    }
}
