<?php

namespace Richardds\ServerAdmin\Core;

use Richardds\ServerAdmin\Core\Commands\Command;
use Richardds\ServerAdmin\Facades\Execute;

class ConfigIo
{
    /**
     * @var string
     */
    private $path;

    /**
     * ConfigIo constructor.
     *
     * @param string $path
     * @param int|null $mode
     */
    public function __construct(string $path, ?int $mode = 644)
    {
        $this->path = escapeshellarg($path);

        Execute::withoutOutput("touch {$path}", true);
        Execute::withoutOutput("chmod {$mode} {$path}", true);
    }

    /**
     * Truncate config file.
     */
    public function truncate()
    {
        Execute::withoutOutput("echo -n > {$this->path}", true);
    }

    /**
     * Read data from config file.
     *
     * @param int $length
     * @return string
     */
    public function read(int $length = -1): string
    {
        if ($length > 0) {
            return Execute::output("head -c {$length} {$this->path}", true);
        }

        return Execute::output("cat {$this->path}", true);
    }

    /**
     * Write data to config file.
     *
     * @param string $content
     */
    public function write(string $content)
    {
        Execute::withoutOutput(Command::create("cat >> {$this->path}", $content), true);
    }

    /**
     * Write line to config file.
     *
     * @param string $content
     */
    public function writeln(string $content)
    {
        $this->write($content . "\n");
    }

    /**
     * Write empty line to config file.
     */
    public function nextline()
    {
        Execute::withoutOutput("echo >> {$this->path}", true);
    }
}
