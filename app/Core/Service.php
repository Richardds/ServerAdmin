<?php
namespace Richardds\ServerAdmin\Core;

use Richardds\ServerAdmin\Core\Commands\ServiceCommand;

class Service
{
    protected $name;

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
     */
    public function start(): void
    {
        ServiceCommand::start($this->name);
    }

    /**
     * Stop service.
     */
    public function stop(): void
    {
        ServiceCommand::stop($this->name);
    }

    /**
     * Restart service.
     */
    public function restart(): void
    {
        ServiceCommand::restart($this->name);
    }

    /**
     * Reload service.
     */
    public function reload(): void
    {
        ServiceCommand::reload($this->name);
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
