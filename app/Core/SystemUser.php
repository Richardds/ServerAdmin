<?php

namespace Richardds\ServerAdmin\Core;

use Illuminate\Contracts\Support\Arrayable;
use Richardds\ServerAdmin\Facades\Execute;

class SystemUser implements Arrayable
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var integer
     */
    protected $uid;

    /**
     * @var integer
     */
    protected $gid;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var string
     */
    protected $home;

    /**
     * @var string
     */
    protected $shell;

    /**
     * @return array
     */
    public static function list(): array
    {
        $passwd = Execute::output('cut -d: -f1 /etc/passwd', true);
        $users = explode("\n", trim($passwd));

        return $users;
    }

    /**
     * @param callable $search
     * @return null|SystemUser
     */
    private static function find(callable $search): ?SystemUser
    {
        $passwd = Execute::output('cat /etc/passwd', true);
        $lines = explode("\n", trim($passwd));

        foreach ($lines as $line) {
            $attributes = explode(':', $line);

            if ($search($attributes)) {
                return new SystemUser(
                    $attributes[0],
                    $attributes[2],
                    $attributes[3],
                    $attributes[4] ?? '',
                    $attributes[5],
                    $attributes[6]
                );
            }
        }

        return null;
    }

    /**
     * @param string $name
     * @return null|SystemUser
     */
    public static function getByName(string $name): ?SystemUser
    {
        return self::find(function ($attributes) use ($name) {
            return $name == $attributes[0] ?? null;
        });
    }

    /**
     * @param int $id
     * @return null|SystemUser
     */
    public static function getById(int $id): ?SystemUser
    {
        return self::find(function ($attributes) use ($id) {
            return $id == $attributes[2] ?? null;
        });
    }

    /**
     * @return SystemUser[]
     */
    public static function getAll(): array
    {
        $users = [];

        foreach (self::list() as $name) {
            $user = self::getByName($name);

            if (!is_null($user)) {
                $users[] = $user;
            }
        }

        return $users;
    }

    /**
     * User constructor.
     *
     * @param string $name
     * @param int $uid
     * @param int $gid
     * @param string $comment
     * @param string $home
     * @param string $shell
     */
    public function __construct(string $name, int $uid, int $gid, string $comment, string $home, string $shell)
    {
        $this->name = $name;
        $this->uid = $uid;
        $this->gid = $gid;
        $this->comment = $comment;
        $this->home = $home;
        $this->shell = $shell;
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
     * @return int
     */
    public function getUid(): int
    {
        return $this->uid;
    }

    /**
     * @param int $uid
     */
    public function setUid(int $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return int
     */
    public function getGid(): int
    {
        return $this->gid;
    }

    /**
     * @param int $gid
     */
    public function setGid(int $gid): void
    {
        $this->gid = $gid;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getHome(): string
    {
        return $this->home;
    }

    /**
     * @param string $home
     */
    public function setHome(string $home): void
    {
        $this->home = $home;
    }

    /**
     * @return string
     */
    public function getShell(): string
    {
        return $this->shell;
    }

    /**
     * @param string $shell
     */
    public function setShell(string $shell): void
    {
        $this->shell = $shell;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'uid' => $this->uid,
            'gid' => $this->gid,
            'comment' => $this->comment,
            'home' => $this->home,
            'shell' => $this->shell,
        ];
    }
}
