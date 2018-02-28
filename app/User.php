<?php

namespace Richardds\ServerAdmin;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Richardds\ServerAdmin\User
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\User whereUsername($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
    ];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = [
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'username' => 'string',
        'password' => 'string',
        'remember_token' => 'string',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    /**
     * @param string $password
     */
    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
