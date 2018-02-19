<?php

namespace Richardds\ServerAdmin\Core\Commands;

use Richardds\ServerAdmin\Core\Service;
use Richardds\ServerAdmin\Facades\Execute;

class ServiceCommand
{
    /**
     * Get list of all loaded services.
     *
     * @return array
     */
    public static function list(): array
    {
        $output = Execute::output("service --status-all", true);

        preg_match_all('/^ \[ (\+|-|\?) \]  ([a-z0-9.-]+)$/mi', $output, $matches, PREG_SET_ORDER, 0);

        $services = [];

        foreach ($matches as $match) {
            $services = $match[2];
        }

        return $services;
    }

    /**
     * Start service.
     *
     * @param string $name
     * @return \Richardds\ServerAdmin\Core\Service
     */
    public static function start(string $name): Service
    {
        Execute::withoutOutput("service {$name} start", true);

        return new Service($name);
    }

    /**
     * Stop service.
     *
     * @param string $name
     * @return \Richardds\ServerAdmin\Core\Service
     */
    public static function stop(string $name): Service
    {
        Execute::withoutOutput("service {$name} stop", true);

        return new Service($name);
    }

    /**
     * Restart service.
     *
     * @param string $name
     * @return \Richardds\ServerAdmin\Core\Service
     */
    public static function restart(string $name): Service
    {
        Execute::withoutOutput("service {$name} restart", true);

        return new Service($name);
    }

    /**
     * Reload service.
     *
     * @param string $name
     * @return \Richardds\ServerAdmin\Core\Service
     */
    public static function reload(string $name): Service
    {
        Execute::withoutOutput("service {$name} reload", true);

        return new Service($name);
    }

    /**
     * Force-Reload service.
     *
     * @param string $name
     * @return \Richardds\ServerAdmin\Core\Service
     */
    public static function forceReload(string $name): Service
    {
        Execute::withoutOutput("service {$name} force-reload", true);

        return new Service($name);
    }

    /**
     * Check if service is running.
     *
     * @param string $name
     * @return bool
     */
    public static function isRunning(string $name): bool
    {
        $output = Execute::output("service --status-all", true);

        preg_match_all('/^ \[ (\+|-|\?) \]  ([a-z0-9.-]+)$/mi', $output, $matches, PREG_SET_ORDER, 0);

        foreach ($matches as $match) {
            if ($name == $match[2]) {
                return '+' == $match[1];
            }
        }

        return false;
    }
}
