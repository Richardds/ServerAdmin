<?php

namespace Richardds\ServerAdmin\Core;

use Richardds\ServerAdmin\Core\Commands\Command;
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
    private function create(string $command, bool $superuser = false): Process
    {
        if ($superuser) {
            $command = "sudo sh -c '{$command}'";
        }

        if (env('APP_DEBUG', false)) {
	        \Debugbar::info($command);
        }

        $process = new Process($command);
        $process->setWorkingDirectory(storage_path('cwd'));
        $process->setTimeout($this->processTimeout);

        return $process;
    }

    /**
     * @param \Richardds\ServerAdmin\Core\Commands\Command|string $command
     * @param bool $superuser
     * @return mixed
     */
    public function output($command, bool $superuser = false)
    {
        if ($command instanceof Command) {
            $process = $this->create($command->getCommand(), $superuser);
            $process->setInput($command->getInput());
        } else {
            $process = $this->create($command, $superuser);
        }

        return $process->mustRun()->getOutput();
    }

    /**
     * @param \Richardds\ServerAdmin\Core\Commands\Command|string $command
     * @param bool $superuser
     * @return void
     */
    public function withoutOutput($command, bool $superuser = false)
    {
        if ($command instanceof Command) {
            $process = $this->create($command->getCommand(), $superuser);
            $process->setInput($command->getInput());
        } else {
            $process = $this->create($command, $superuser);
        }

        $process->disableOutput();
        $process->mustRun();
    }
}
