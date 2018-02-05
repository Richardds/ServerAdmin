<?php

namespace Richardds\ServerAdmin;

use Illuminate\Database\Eloquent\Model;

class MailAlias extends Model
{
    protected $fillable = [
        'id',
        'domain_id',
        'source',
        'destination',
    ];

    protected $visible = [
        'id',
        'domain_id',
        'source',
        'destination',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'domain_id' => 'integer',
        'source' => 'string',
        'destination' => 'string',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    public function domain()
    {
        return $this->belongsTo(MailDomain::class);
    }
}
