<?php

namespace Richardds\ServerAdmin\Core;

class MultipleServices extends Service
{
    /**
     * @var array
     */
    protected $services;

    /**
     * MultipleServices constructor.
     *
     * @param array $services
     */
    public function __construct(array $services)
    {
        parent::__construct('');
        $this->services = $services;
    }

    /**
     * Start service.
     */
    public function start(): void
    {
        foreach ($this->services as $service) {
            $this->name = $service;
            parent::start();
        }

        $this->name = '';
    }

    /**
     * Stop service.
     */
    public function stop(): void
    {
        foreach ($this->services as $service) {
            $this->name = $service;
            parent::stop();
        }

        $this->name = '';
    }

    /**
     * Restart service.
     */
    public function restart(): void
    {
        foreach ($this->services as $service) {
            $this->name = $service;
            parent::restart();
        }

        $this->name = '';
    }

    /**
     * Reload service.
     */
    public function reload(): void
    {
        foreach ($this->services as $service) {
            $this->name = $service;
            parent::reload();
        }

        $this->name = '';
    }

    /**
     * Check if service is running.
     *
     * @return bool
     */
    public function isRunning(): bool
    {
        foreach ($this->services as $service) {
            $this->name = $service;

            if (!parent::isRunning()) {
                $this->name = '';

                return false;
            }
        }

        $this->name = '';

        return true;
    }
}
