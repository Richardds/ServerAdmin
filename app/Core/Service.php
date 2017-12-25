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

    /**
     * Start service.
     *
     * @return Service
     */
    public function start(): Service
    {
        return ServiceCommand::start($this->name);
    }

    /**
     * Stop service.
     *
     * @return Service
     */
    public function stop(): Service
    {
        return ServiceCommand::stop($this->name);
    }

    /**
     * Restart service.
     *
     * @return Service
     */
    public function restart(): Service
    {
        return ServiceCommand::restart($this->name);
    }

    /**
     * Reload service.
     *
     * @return Service
     */
    public function reload(): Service
    {
        return ServiceCommand::reload($this->name);
    }

    /**
     * Check if service is running.
     *
     * @return bool
     */
    public function isRunning(): bool
    {
        return ServiceCommand::isRunning($this->name);
    }
}
