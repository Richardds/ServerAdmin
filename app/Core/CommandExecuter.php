<?php

namespace Richardds\ServerAdmin\Core;

use Symfony\Component\Process\Process;

class CommandExecuter
{
    protected $processTimeout;

    public function __construct()
    {
        $this->processTimeout = env('PROCESS_TIMEOUT', 60);
    }

    public function create(string $command)
    {
        $process = new Process($command);
        $process->setWorkingDirectory(storage_path('cwd'));
        $process->setTimeout($this->processTimeout);

        return $process;
    }

    public function execute(string $command, callable $callback = null)
    {
        $this->create($command)->mustRun($callback);
    }

    public function output(string $command)
    {
        $process = $this->create($command);
        $process->mustRun();

        return $process->getOutput();
    }

    public function executeWithoutOutput(string $command)
    {
        $process = $this->create($command);
        $process->disableOutput();
        $process->mustRun();
    }
}
