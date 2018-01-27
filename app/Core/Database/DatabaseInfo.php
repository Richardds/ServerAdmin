<?php

namespace Richardds\ServerAdmin\Core\Database;

use Illuminate\Contracts\Support\Arrayable;

class DatabaseInfo implements Arrayable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $character_set;

    /**
     * @var string
     */
    private $collation;

    /**
     * @var int
     */
    private $tables_count;

    /**
     * @var int
     */
    private $size;

    /**
     * @var boolean
     */
    private $protected;

    /**
     * DatabaseInfo constructor.
     *
     * @param string $name
     * @param string $character_set
     * @param string $collation
     * @param int $tables_count
     * @param int $size
     * @param bool $protected
     */
    public function __construct(
        string $name,
        string $character_set,
        string $collation,
        int $tables_count,
        int $size,
        bool $protected
    ) {
        $this->name = $name;
        $this->character_set = $character_set;
        $this->collation = $collation;
        $this->tables_count = $tables_count;
        $this->size = $size;
        $this->protected = $protected;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCharacterSet(): string
    {
        return $this->character_set;
    }

    /**
     * @param string $character_set
     */
    public function setCharacterSet(string $character_set): void
    {
        $this->character_set = $character_set;
    }

    /**
     * @return string
     */
    public function getCollation(): string
    {
        return $this->collation;
    }

    /**
     * @param string $collation
     */
    public function setCollation(string $collation): void
    {
        $this->collation = $collation;
    }

    /**
     * @return int
     */
    public function getTablesCount(): int
    {
        return $this->tables_count;
    }

    /**
     * @param int $tables_count
     */
    public function setTablesCount(int $tables_count): void
    {
        $this->tables_count = $tables_count;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * @return bool
     */
    public function isProtected(): bool
    {
        return $this->protected;
    }

    /**
     * @param bool $protected
     */
    public function setProtected(bool $protected): void
    {
        $this->protected = $protected;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'character_set' => $this->character_set,
            'collation' => $this->collation,
            'tables_count' => $this->tables_count,
            'size' => $this->size,
            'protected' => $this->protected,
        ];
    }
}
