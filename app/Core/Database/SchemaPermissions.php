<?php

namespace Richardds\ServerAdmin\Core\Database;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\DB;
use Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException;

class SchemaPermissions implements Arrayable
{
    /**
     * @var array
     */
    private static $requiredPermissions = [
        SchemaPermission::SELECT,
        SchemaPermission::INSERT,
        SchemaPermission::UPDATE,
        SchemaPermission::DELETE,
        SchemaPermission::CREATE,
        SchemaPermission::DROP,
        SchemaPermission::REFERENCES,
        SchemaPermission::INDEX,
        SchemaPermission::ALTER,
        SchemaPermission::CREATE_TMP_TABLE,
        SchemaPermission::LOCK_TABLES,
        SchemaPermission::CREATE_VIEW,
        SchemaPermission::SHOW_VIEW,
        SchemaPermission::CREATE_ROUTINE,
        SchemaPermission::ALTER_ROUTINE,
        SchemaPermission::EXECUTE,
        SchemaPermission::EVENT,
        SchemaPermission::TRIGGER,
    ];

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $permissions;

    /**
     * @param string $name
     * @return SchemaPermissions
     */
    public static function load(string $name)
    {
        $schemPermissions = new SchemaPermissions($name);
        $schemPermissions->reload();

        return $schemPermissions;
    }

    /**
     * SchemaPermissions constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Fetch latest user permissions for given schema.
     */
    public function reload(): void
    {
        $query = <<< EOT
        SELECT
          mdb.host,
          mdb.user,
          REPLACE(RTRIM(CONCAT(
            IF(mdb.Select_priv = 'Y', 'SELECT ', ''),
            IF(mdb.Insert_priv = 'Y', 'INSERT ', ''),
            IF(mdb.Update_priv = 'Y', 'UPDATE ', ''),
            IF(mdb.Delete_priv = 'Y', 'DELETE ', ''),
            IF(mdb.Create_priv = 'Y', 'CREATE ', ''),
            IF(mdb.Drop_priv = 'Y', 'DROP ', ''),
            IF(mdb.Grant_priv = 'Y', 'GRANT ', ''),
            IF(mdb.References_priv = 'Y', 'REFERENCES ', ''),
            IF(mdb.Index_priv = 'Y', 'INDEX ', ''),
            IF(mdb.Alter_priv = 'Y', 'ALTER ', ''),
            IF(mdb.Create_tmp_table_priv = 'Y', 'CREATE_TMP_TABLE ', ''),
            IF(mdb.Lock_tables_priv = 'Y', 'LOCK_TABLES ', ''),
            IF(mdb.Create_view_priv = 'Y', 'CREATE_VIEW ', ''),
            IF(mdb.Show_view_priv = 'Y', 'SHOW_VIEW ', ''),
            IF(mdb.Create_routine_priv = 'Y', 'CREATE_ROUTINE ', ''),
            IF(mdb.Alter_routine_priv = 'Y', 'ALTER_ROUTINE ', ''),
            IF(mdb.Execute_priv = 'Y', 'EXECUTE ', ''),
            IF(mdb.Event_priv = 'Y', 'EVENT ', ''),
            IF(mdb.Trigger_priv = 'Y', 'TRIGGER ', '')
          )), ' ', ',') AS `privileges`
        FROM mysql.db mdb
        WHERE mdb.db = :database
EOT;
        $users = DB::select($query, [
            'database' => $this->name
        ]);

        foreach ($users as $user) {
            $this->permissions[$user->user . '@' . $user->host] = explode(',', $user->privileges);
        }
    }

    /**
     * @param string $user
     * @param string $permission
     * @return bool
     * @throws InvalidParameterException
     */
    public function hasPermission(string $user, string $permission): bool
    {
        if (false !== strpos($user, '@')) {
            return (isset($this->permissions[$user]) && in_array($permission, $this->permissions[$user]));
        } else {
            // TODO: Non user@host format
            throw new InvalidParameterException('Non user@host format', [
                'user' => $user,
                'permission' => $permission
            ]);
        }
    }

    /**
     * @param string $user
     * @return bool
     * @throws InvalidParameterException
     */
    public function hasRequiredPermissions(string $user): bool {
        foreach (self::$requiredPermissions as $requiredPermission) {
            if (!$this->hasPermission($user, $requiredPermission)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     * @throws InvalidParameterException
     */
    public function toArray(): array
    {
        if (0 == count($this->permissions)) {
            return [];
        }

        $permissions = [];

        foreach ($this->permissions as $userFull => $userPermissions) {
            $parts = explode('@', $userFull);
            $user = $parts[0];
            $host = $parts[1];

            $permissions[] = [
                'user' => $user,
                'host' => $host,
                'required' => $this->hasRequiredPermissions($userFull),
                'permissions' => $userPermissions,
            ];
        }

        return $permissions;
    }
}
