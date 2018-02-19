<?php

namespace Richardds\ServerAdmin;

use Illuminate\Database\Eloquent\Model;

/**
 * Richardds\ServerAdmin\MailDomain
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\Richardds\ServerAdmin\MailUser[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailDomain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailDomain whereName($value)
 * @mixin \Eloquent
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailDomain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailDomain whereUpdatedAt($value)
 */
class MailDomain extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $visible = [
        'id',
        'name',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(MailUser::class, 'domain_id');
    }
}
