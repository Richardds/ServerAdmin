<?php

namespace Richardds\ServerAdmin;

use Illuminate\Database\Eloquent\Model;

class MailAlias extends Model
{
    protected $fillable = [
        'id',
        'domain_id',
        'user_id',
        'alias',
    ];

    protected $visible = [
        'id',
        'domain_id',
        'user_id',
        'alias',
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
