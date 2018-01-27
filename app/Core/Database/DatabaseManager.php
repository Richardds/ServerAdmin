<?php

namespace Richardds\ServerAdmin\Core\Database;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Richardds\ServerAdmin\Core\Service;

class DatabaseManager extends Service
{
    private $protected_tables = [
        'information_schema',
        'performance_schema',
        'mysql',
        'serveradmin',
    ];

    /**
     * DatabaseManager constructor.
     */
    public function __construct()
    {
        parent::__construct('mysql');
    }

    /**
     * @param string $name
     * @param null|string $character_set
     * @param null|string $collation
     */
    public function createDatabase(string $name, ?string $character_set = null, ?string $collation = null): void
    {
        if (is_null($character_set) && is_null($character_set)) {
            DB::statement('CREATE DATABASE :database', [
                'database' => $name
            ]);
        } else if (!is_null($character_set) && is_null($character_set)) {
            DB::statement('CREATE DATABASE :database CHARACTER SET :charset', [
                'database' => $name,
                'charset' => $character_set,
            ]);
        } else {
            DB::statement('CREATE DATABASE :database CHARACTER SET :charset COLLATE :collation', [
                'database' => $name,
                'charset' => $character_set,
                'collation' => $collation,
            ]);
        }
    }

    /**
     * @param string $name
     */
    public function dropDatabase(string $name): void
    {
        DB::statement('DROP DATABASE :database', [
            'database' => $name
        ]);
    }

    /**
     * @return string[]
     */
    public function getDatabases(): array
    {
        return Collection::make(DB::select('SHOW DATABASES'))->pluck('Database')->toArray();
    }

    /**
     * @param string $name
     * @return DatabaseInfo
     */
    public function getDatabaseInfo(string $name): DatabaseInfo
    {
        $detailsResult = DB::selectOne('SELECT * FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = :database', [
            'database' => $name
        ]);

        $countResult = DB::selectOne('SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = :database', [
            'database' => $name
        ]);

        $sizeResult = DB::selectOne('SELECT ROUND(SUM(data_length + index_length), 0) AS size FROM information_schema.tables WHERE table_schema = :database GROUP BY table_schema', [
            'database' => $name
        ]);

        return new DatabaseInfo(
            $detailsResult->SCHEMA_NAME,
            $detailsResult->DEFAULT_CHARACTER_SET_NAME,
            $detailsResult->DEFAULT_COLLATION_NAME,
            $countResult->count,
            $sizeResult->size ?? 0,
            in_array($detailsResult->SCHEMA_NAME, $this->protected_tables)
        );
    }

    /**
     * @return string[]
     */
    public function getAvailableCharacterSets(): array
    {
        return Collection::make(DB::select('SHOW CHARACTER SET'))->pluck('Charset')->toArray();
    }

    /**
     * @return string[]
     */
    public function getAvailableCollations(): array
    {
        return Collection::make(DB::select('SHOW COLLATION'))->pluck('Collation')->toArray();
    }

    public function getUsers()
    {

    }
}
