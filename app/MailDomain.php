<?php

namespace Richardds\ServerAdmin;

use Illuminate\Database\Eloquent\Model;

/**
 * Richardds\ServerAdmin\MailDomain
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Richardds\ServerAdmin\MailUser[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailDomain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailDomain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailDomain whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailDomain whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MailDomain extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'created_at',
        'updated_at',
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
