<?php

namespace Richardds\ServerAdmin;

use Illuminate\Database\Eloquent\Model;
use Richardds\ServerAdmin\Scopes\Local\Toggles;

/**
 * Richardds\ServerAdmin\DnsZone
 *
 * @property int $id
 * @property string $name
 * @property string $admin
 * @property int $serial
 * @property int $refresh
 * @property int $retry
 * @property int $expire
 * @property int $ttl
 * @property bool $enabled
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Richardds\ServerAdmin\DnsRecord[] $dnsRecords
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsZone enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsZone whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsZone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsZone whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsZone whereExpire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsZone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsZone whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsZone whereRefresh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsZone whereRetry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsZone whereSerial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsZone whereTtl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsZone whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DnsZone extends Model
{
    use Toggles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'admin',
        'serial',
        'refresh',
        'retry',
        'expire',
        'ttl',
        'enabled',
    ];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'admin',
        'serial',
        'refresh',
        'retry',
        'expire',
        'ttl',
        'enabled',
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
        'name' => 'string',
        'admin' => 'string',
        'serial' => 'integer',
        'refresh' => 'integer',
        'retry' => 'integer',
        'expire' => 'integer',
        'ttl' => 'integer',
        'enabled' => 'boolean',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    public function dnsRecords()
    {
        return $this->hasMany(DnsRecord::class, 'zone_id');
    }
}
