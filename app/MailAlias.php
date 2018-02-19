<?php

namespace Richardds\ServerAdmin;

use Illuminate\Database\Eloquent\Model;

/**
 * Richardds\ServerAdmin\MailAlias
 *
 * @property int $id
 * @property int $domain_id
 * @property int $user_id
 * @property string $alias
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Richardds\ServerAdmin\MailDomain $domain
 * @property-read \Richardds\ServerAdmin\MailUser $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailAlias whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailAlias whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailAlias whereDomainId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailAlias whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailAlias whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\MailAlias whereUserId($value)
 * @mixin \Eloquent
 */
class MailAlias extends Model
{
    protected $fillable = [
        'domain_id',
        'user_id',
        'alias',
    ];

    protected $visible = [
        'id',
        'domain_id',
        'user_id',
        'alias',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'domain_id' => 'integer',
        'user_id' => 'integer',
        'alias' => 'string',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(MailUser::class);
    }
}
