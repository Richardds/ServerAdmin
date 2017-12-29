<?php

namespace Richardds\ServerAdmin;

use Illuminate\Database\Eloquent\Model;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsRecordAssistance;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsRecordAttributes;

/**
 * Richardds\ServerAdmin\DnsRecord
 *
 * @property int $id
 * @property int $zone_id
 * @property string $type
 * @property string $name
 * @property DnsRecordAttributes $attrs
 * @property int $ttl
 * @property bool $enabled
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Richardds\ServerAdmin\DnsZone $dnsZone
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
    use DnsRecordAssistance;

    const DNS_A_RECORD = 'A';

    const DNS_AAAA_RECORD = 'AAAA';

    const DNS_CNAME_RECORD = 'CNAME';

    const DNS_MX_RECORD = 'MX';

    const DNS_SRV_RECORD = 'SRV';

    const DNS_TXT_RECORD = 'TXT';

    const DNS_NS_RECORD = 'NS';

    protected $fillable = [
        'zone_id',
        'type',
        'name',
        'attrs',
        'ttl',
        'enabled',
    ];

    protected $visible = [
        'id',
        'zone_id',
        'type',
        'name',
        'attrs',
        'ttl',
        'enabled',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

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
            self::DNS_A_RECORD,
            self::DNS_AAAA_RECORD,
            self::DNS_CNAME_RECORD,
            self::DNS_MX_RECORD,
            self::DNS_SRV_RECORD,
            self::DNS_TXT_RECORD,
            self::DNS_NS_RECORD,
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
