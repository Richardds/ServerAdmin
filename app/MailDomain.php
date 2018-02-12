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
 */
class MailDomain extends Model
{
    protected $fillable = [
        'id',
        'name',
    ];

    protected $visible = [
        'id',
        'name',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
    ];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(MailUser::class, 'domain_id');
    }
}
