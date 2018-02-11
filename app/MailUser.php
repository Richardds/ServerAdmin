<?php

namespace Richardds\ServerAdmin;

use Illuminate\Database\Eloquent\Model;

class MailUser extends Model
{
    protected $fillable = [
        'id',
        'domain_id',
        'username',
        'password',
    ];

    protected $visible = [
        'id',
        'domain_id',
        'username',
        'password',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'domain_id' => 'integer',
        'username' => 'string',
        'password' => 'string',
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
}
