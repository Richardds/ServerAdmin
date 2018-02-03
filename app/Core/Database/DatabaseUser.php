<?php

namespace Richardds\ServerAdmin\Core\Database;

use Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException;

class DatabaseUser
{
    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $password;

    /**
     * @param string $user
     * @return DatabaseUser
     * @throws InvalidParameterException
     */
    public static function fromSingleString(string $user): DatabaseUser
    {
        $parts = explode('@', $user);

        if (count($parts) != 2) {
            throw new InvalidParameterException('Invalid database user format', [
                'user' => $user
            ]);
        }

        return new DatabaseUser($parts[0], $parts[1]);
    }

    /**
     * DatabaseUser constructor.
     * @param string $user
     * @param string $host
     * @param string $password
     */
    public function __construct(string $user, string $host, ?string $password = null)
    {
        $this->user = $user;
        $this->host = $host;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser(string $user): void
    {
        $this->user = $user;
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
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function toSql(): string
    {
        return "'{$this->user}'@'{$this->host}'";
    }
}
