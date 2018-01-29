<?php

namespace Richardds\ServerAdmin\Core\Database;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\DB;

class SchemaInfo implements Arrayable
{
    private static $protected_tables = [
        'information_schema',
        'performance_schema',
        'mysql',
        'serveradmin',
    ];

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
     * @var SchemaPermissions
     */
    private $permissions;

    /**
     * @param string $name
     * @return SchemaInfo
     */
    public static function load(string $name): SchemaInfo
    {
        $schemaInfo = new SchemaInfo($name);
        $schemaInfo->reload();

        return $schemaInfo;
    }

    /**
     * SchemaInfo constructor.
     * @param string $name
     */
    private function __construct(string $name) {
        $this->name = $name;
    }

    /**
     * Fetch latest schema info.
     */
    public function reload(): void
    {
        $detailsResult = DB::selectOne('SELECT * FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = :database', [
            'database' => $this->name
        ]);

        $countResult = DB::selectOne('SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = :database', [
            'database' => $this->name
        ]);

        $sizeResult = DB::selectOne('SELECT ROUND(SUM(data_length + index_length), 0) AS size FROM information_schema.tables WHERE table_schema = :database GROUP BY table_schema', [
            'database' => $this->name
        ]);

        // TODO: Throw exception when database is missing.

        $this->character_set = $detailsResult->DEFAULT_CHARACTER_SET_NAME;
        $this->collation = $detailsResult->DEFAULT_COLLATION_NAME;
        $this->tables_count = $countResult->count;
        $this->size = $sizeResult->size ?? 0;
        $this->protected = in_array($detailsResult->SCHEMA_NAME, self::$protected_tables);

        if (isset($this->permissions)) {
            $this->permissions->reload();
        } else {
            $this->permissions = SchemaPermissions::load($this->name);
        }
    }

    /**
     * @return array
     */
    public static function getProtectedTables(): array
    {
        return self::$protected_tables;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCharacterSet(): string
    {
        return $this->character_set;
    }

    /**
     * @return string
     */
    public function getCollation(): string
    {
        return $this->collation;
    }

    /**
     * @return int
     */
    public function getTablesCount(): int
    {
        return $this->tables_count;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return bool
     */
    public function isProtected(): bool
    {
        return $this->protected;
    }

    /**
     * @return SchemaPermissions
     */
    public function getPermissions(): SchemaPermissions
    {
        return $this->permissions;
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
            'access' => $this->permissions->toArray(),
        ];
    }
}
