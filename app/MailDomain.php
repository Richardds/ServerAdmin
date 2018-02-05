<?php

namespace Richardds\ServerAdmin;

use Illuminate\Database\Eloquent\Model;

class MailDomain extends Model
{
    protected $fillable = [
        'id',
        'domain',
    ];

    protected $visible = [
        'id',
        'domain',
    ];

    protected $casts = [
        'id' => 'integer',
        'domain' => 'string',
    ];
}
