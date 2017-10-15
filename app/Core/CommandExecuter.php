<?php

namespace Richardds\ServerAdmin\Core;

use Symfony\Component\Process\Process;

class CommandExecuter
{
    /**
     * @var int
     */
    protected $processTimeout;

    /**
     * CommandExecuter constructor.
     */
    public function __construct()
    {
        $this->processTimeout = env('PROCESS_TIMEOUT', 60);
    }

    /**
     * @param string $command
     * @param bool $superuser
     * @return \Symfony\Component\Process\Process
     */
    private function create(string $command, bool $superuser = false)
    {
        if ($superuser) {
            $escapedCommand = str_replace('\'', '\'\\\'\'', $command);
            $command = "sudo sh -c '{$escapedCommand}'";
        }

        $process = new Process($command);
        $process->setWorkingDirectory(storage_path('cwd'));
        $process->setTimeout($this->processTimeout);

        return $process;
    }

    /**
     * @param string $command
     * @param bool $superuser
     * @return string
     */
    public function output(string $command, bool $superuser = false)
    {
        $process = $this->create($command, $superuser);
        $process->mustRun();

        return $process->getOutput();
    }

    /**
     * @param string $command
     * @param bool $superuser
     */
    public function executeWithoutOutput(string $command, bool $superuser = false)
    {
        $process = $this->create($command, $superuser);
        $process->disableOutput();
        $process->mustRun();
    }
}
