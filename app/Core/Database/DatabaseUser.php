<?php

namespace Richardds\ServerAdmin\Core\Database;

class DatabaseUser
{
    private static $availablePermissions = [
        'Select_priv',
        'Insert_priv',
        'Update_priv',
        'Delete_priv',
        'Create_priv',
        'Drop_priv',
        'Reload_priv',
        'Shutdown_priv',
        // TODO: SELECT * FROM COLUMNS WHERE TABLE_SCHEMA = 'mysql' AND TABLE_NAME = 'user' AND DATA_TYPE = 'enum'
    ];

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $host;

    /**
     * @var array
     */
    private $permissions;

    /**
     * DatabaseUser constructor.
     * @param string $name
     * @param string $host
     * @param array $permissions
     */
    public function __construct(string $name, string $host, array $permissions)
    {
        $this->name = $name;
        $this->host = $host;
        $this->permissions = $permissions;
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
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @param array $permissions
     */
    public function setPermissions(array $permissions): void
    {
        $this->permissions = $permissions;
    }
}
