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
        if (is_null($character_set) && is_null($collation)) {
            DB::statement('CREATE DATABASE ?;', [$name]);
        } else if (!is_null($character_set) && is_null($collation)) {
            DB::statement('CREATE DATABASE ? CHARACTER SET ?;', [$name, $character_set]);
        } else {
            DB::statement('CREATE DATABASE ? CHARACTER SET ? COLLATE ?;', [$name, $character_set, $collation]);
        }
    }

    /**
     * @param string $name
     */
    public function dropDatabase(string $name): void
    {
        DB::statement('DROP DATABASE ?;', [$name]);
    }

    /**
     * @param DatabaseUser $user
     */
    public function createUser(DatabaseUser $user): void
    {
        DB::statement('CREATE USER ? IDENTIFIED BY \'?\';', [$user->toSql(), $user->getPassword()]);
    }

    /**
     * @param DatabaseUser $user
     */
    public function dropUser(DatabaseUser $user): void
    {
        DB::statement('DROP USER ?;', [$user->toSql()]);
    }

    /**
     * @param string $name
     * @param DatabaseUser $user
     */
    public function grantPermissions(string $name, DatabaseUser $user): void
    {
        DB::statement('GRANT ALL ON ? TO ?;', [$name . '.*', $user->toSql()]);
        $this->reloadPrivileges();
    }

    /**
     * @param string $name
     * @param DatabaseUser $user
     */
    public function revokePermissions(string $name, DatabaseUser $user): void
    {
        DB::statement('REVOKE ALL ON ? FROM ?;', [$name . '.*', $user->toSql()]);
        $this->reloadPrivileges();
    }

    /**
     * Reload database privileges.
     */
    public function reloadPrivileges(): void
    {
        DB::statement('FLUSH PRIVILEGES;');
    }

    /**
     * @return string[]
     */
    public function getDatabases(): array
    {
        return Collection::make(DB::select('SHOW DATABASES;'))->pluck('Database')->toArray();
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
     * @param string $name
     * @return SchemaInfo
     */
    public function getFullDatabaseInfo(string $name): SchemaInfo
    {
        return SchemaInfo::load($name, true);
    }

    /**
     * @return string[]
     */
    public function getAvailableCharacterSets(): array
    {
        return Collection::make(DB::select('SHOW CHARACTER SET;'))->pluck('Charset')->toArray();
    }

    /**
     * @return string[]
     */
    public function getAvailableCollations(): array
    {
        return Collection::make(DB::select('SHOW COLLATION;'))->pluck('Collation')->toArray();
    }

    /**
     * @return string[]
     */
    public function getAvailableUsers(): array
    {
        $users = [];
        $result = DB::select('SELECT `user`, `host` FROM `mysql`.`user`;');

        foreach ($result as $user) {
            $users[] = [
                'user' => $user->user,
                'host' => $user->host,
            ];
        }

        return $users;
    }
}
