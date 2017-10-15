<?php

namespace Richardds\ServerAdmin\Core;

use Richardds\ServerAdmin\Facades\Command;

class ConfigIo
{
    /**
     * @var string
     */
    private $path;

    /**
     * ConfigIo constructor.
     *
     * @param $path
     */
    public function __construct(string $path)
    {
        $this->path = escapeshellarg($path);
    }

    /**
     * Truncate config file.
     */
    public function truncate()
    {
        Command::executeWithoutOutput("echo -n > {$this->path}", true);
    }

    /**
     * Read data from config file.
     *
     * @param int $length
     * @return mixed
     */
    public function read(int $length = -1)
    {
        if ($length > 0) {
            return Command::output("head -c {$length} {$this->path}", true);
        }

        return Command::output("cat {$this->path}", true);
    }

    /**
     * Write data to config file.
     *
     * @param string $content
     */
    public function write(string $content)
    {
        $content = escapeshellarg($content);
        Command::executeWithoutOutput("echo -e -n {$content} >> {$this->path}", true);
    }

    /**
     * Write line to config file.
     *
     * @param string $content
     */
    public function writeln(string $content)
    {
        $content = escapeshellarg($content);
        Command::executeWithoutOutput("echo -e {$content} >> {$this->path}", true);
    }

    /**
     * Write empty line to config file.
     */
    public function nextline()
    {
        Command::executeWithoutOutput("echo >> {$this->path}", true);
    }
}
