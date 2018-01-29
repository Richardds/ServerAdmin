<?php

namespace Richardds\ServerAdmin\Core\Database;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Richardds\ServerAdmin\Core\Service;

class DatabaseManager extends Service
{
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
     * @return SchemaInfo
     */
    public function getDatabaseInfo(string $name): SchemaInfo
    {
        return SchemaInfo::load($name);
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

    /**
     * @return string[]
     */
    public function getAvailableUsers(): array
    {
        return Collection::make(DB::select('SELECT CONCAT(user, \'@\', host) AS user FROM mysql.user'))->pluck('user')->toArray();
    }

    public function getUsers()
    {

    }
}
