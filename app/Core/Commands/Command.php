<?php

namespace Richardds\ServerAdmin\Core\Commands;

class Command
{
    private $stdin;

    private $command;

    public function __construct(string $command)
    {
        $this->command = $command;
    }

    public static function create(string $command, $input = null)
    {
        return (new self($command))->withInput($input);
    }

    public function withInput($input)
    {
        $this->stdin = $input;

        return $this;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getInput()
    {
        return $this->stdin;
    }
}
