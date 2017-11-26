<?php
namespace Richardds\ServerAdmin\Core;

use Richardds\ServerAdmin\Core\Commands\ServiceCommand;

class Service
{
    private $name;

    /**
     * Service constructor.
     *
     * @param $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function isRunning(): bool {
        return ServiceCommand::isRunning($this->name);
    }
}
