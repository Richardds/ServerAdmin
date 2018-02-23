<?php

namespace Richardds\ServerAdmin\Core\Database;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\DB;
use Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException;

class SchemaInfo implements Arrayable
{
    private static $protected_tables = [
        'information_schema',
        'performance_schema',
        'mysql',
        'serveradmin',
    ];

    private static $loaded = false;

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
     * @param bool $fetchAll
     * @return SchemaInfo
     */
    public static function load(string $name, bool $fetchAll = false): SchemaInfo
    {
        $schemaInfo = new SchemaInfo($name);
        $schemaInfo->reload($fetchAll);

        return $schemaInfo;
    }

    public static function isProtectedSchema(string $name): bool
    {
        if (!self::$loaded) {
            $loaded_protected_tables = env('DB_PROTECTED');

            if (!is_null($loaded_protected_tables)) {
                self::$protected_tables = explode(',', $loaded_protected_tables);
            }

            self::$loaded = true;
        }

        return in_array($name, self::$protected_tables);
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
     *
     * @param bool $fetchAll
     * @throws InvalidParameterException
     */
    public function reload(bool $fetchAll = false): void
    {
        $detailsResult = DB::selectOne('SELECT * FROM `information_schema`.`SCHEMATA` WHERE `SCHEMA_NAME` = :database;', [
            'database' => $this->name
        ]);

        $countResult = DB::selectOne('SELECT COUNT(*) AS `count` FROM `information_schema`.`tables` WHERE `table_schema` = :database;', [
            'database' => $this->name
        ]);

        $sizeResult = DB::selectOne('SELECT ROUND(SUM(`data_length` + `index_length`), 0) AS `size` FROM `information_schema`.`tables` WHERE `table_schema` = :database GROUP BY `table_schema`;', [
            'database' => $this->name
        ]);

        if (is_null($detailsResult) || is_null($countResult) || is_null($sizeResult)) {
            throw new InvalidParameterException('Schema does not exist', ['schema' => $this->name]);
        }

        $this->character_set = $detailsResult->DEFAULT_CHARACTER_SET_NAME;
        $this->collation = $detailsResult->DEFAULT_COLLATION_NAME;
        $this->tables_count = $countResult->count;
        $this->size = $sizeResult->size ?? 0;
        $this->protected = SchemaInfo::isProtectedSchema($detailsResult->SCHEMA_NAME);

        if ($fetchAll) {
            if (isset($this->permissions)) {
                $this->permissions->reload();
            } else {
                $this->permissions = SchemaPermissions::load($this->name);
            }
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
     * @throws \Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException
     */
    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'character_set' => $this->character_set,
            'collation' => $this->collation,
            'tables_count' => $this->tables_count,
            'size' => $this->size,
            'protected' => $this->protected,
        ];

        if (isset($this->permissions)) {
            $data['access'] = $this->permissions->toArray();
        }

        return $data;
    }
}
