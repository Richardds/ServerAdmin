<?php

namespace Richardds\ServerAdmin;

use Illuminate\Database\Eloquent\Model;

/**
 * Richardds\ServerAdmin\MailUser
 *
 * @property int $id
 * @property int $domain_id
 * @property string $username
 * @property string $password
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Richardds\ServerAdmin\MailAlias[] $aliases
 * @property-read \Richardds\ServerAdmin\MailDomain $domain
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailUser whereDomainId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailUser whereUsername($value)
 * @mixin \Eloquent
 */
class MailUser extends Model
{
    protected $fillable = [
        'id',
        'domain_id',
        'name',
        'username',
        'password',
        'enabled',
    ];

    protected $visible = [
        'id',
        'domain_id',
        'name',
        'username',
        'enabled',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'domain_id' => 'integer',
        'name' => 'string',
        'username' => 'string',
        'password' => 'string',
        'enabled' => 'boolean',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domain()
    {
        return $this->belongsTo(MailDomain::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aliases()
    {
        return $this->hasMany(MailAlias::class, 'user_id');
    }

    /**
     * @param string $password
     */
    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['password'] = sha512crypt($password);
    }
}
