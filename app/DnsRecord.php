<?php

namespace Richardds\ServerAdmin;

use Illuminate\Database\Eloquent\Model;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsRecordAssistance;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsRecordAttributes;
use Richardds\ServerAdmin\Scopes\Local\Toggles;

/**
 * Richardds\ServerAdmin\DnsRecord
 *
 * @property int $id
 * @property int $zone_id
 * @property string $type
 * @property string $name
 * @property array $attrs
 * @property int $ttl
 * @property bool $enabled
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Richardds\ServerAdmin\DnsZone $dnsZone
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsRecord enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsRecord whereAttrs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsRecord whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsRecord whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsRecord whereTtl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsRecord whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\DnsRecord whereZoneId($value)
 * @mixin \Eloquent
 */
class DnsRecord extends Model
{
    use Toggles;

    use DnsRecordAssistance;

    const RECORD_A = 'A';

    const RECORD_AAAA = 'AAAA';

    const RECORD_CNAME = 'CNAME';

    const RECORD_MX = 'MX';

    const RECORD_SRV = 'SRV';

    const RECORD_TXT = 'TXT';

    const RECORD_NS = 'NS';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'zone_id',
        'type',
        'name',
        'attrs',
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
        'zone_id',
        'type',
        'name',
        'attrs',
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
        'zone_id' => 'integer',
        'type' => 'string',
        'name' => 'string',
        'attrs' => 'array',
        'ttl' => 'integer',
        'enabled' => 'boolean',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    public static function availableTypes()
    {
        return [
            self::RECORD_A,
            self::RECORD_AAAA,
            self::RECORD_CNAME,
            self::RECORD_MX,
            self::RECORD_SRV,
            self::RECORD_TXT,
            self::RECORD_NS,
        ];
    }

    public function dnsZone()
    {
        return $this->belongsTo(DnsZone::class);
    }

    public function getAttrsAttribute(string $value): DnsRecordAttributes
    {
        $attrs = json_decode($value, true);

        return self::createDnsRecordAttributes($this->type, $attrs);
    }

    public function setAttrsAttribute(DnsRecordAttributes $value)
    {
        $this->attributes['attrs'] = json_encode($value->toArray());
    }
}
