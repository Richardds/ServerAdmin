<?php

namespace Richardds\ServerAdmin;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsAAAARecordAttributes;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsARecordAttributes;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsCNAMERecordAttributes;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsMXRecordAttributes;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsNSRecordAttributes;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsRecordAttributes;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsSRVRecordAttributes;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsTXTRecordAttributes;

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
    const DNS_A_RECORD = 'A';

    const DNS_AAAA_RECORD = 'AAAA';

    const DNS_CNAME_RECORD = 'CNAME';

    const DNS_MX_RECORD = 'MX';

    const DNS_SRV_RECORD = 'SRV';

    const DNS_TXT_RECORD = 'TXT';

    const DNS_NS_RECORD = 'NS';

    protected $fillable = [
        'type',
        'name',
        'value',
        'ttl',
    ];

    protected $visible = [
        'id',
        'zone_id',
        'type',
        'name',
        'value',
        'ttl',
        'enabled',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'type' => 'string',
        'name' => 'string',
        'attrs' => 'string',
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

    public function getAttrsAttribute($value): DnsRecordAttributes
    {
        $attrs = json_decode($value, true);
        switch ($this->type) {
            case self::DNS_A_RECORD:
                return DnsARecordAttributes::fromArray($attrs);
            case self::DNS_AAAA_RECORD:
                return DnsAAAARecordAttributes::fromArray($attrs);
            case self::DNS_CNAME_RECORD:
                return DnsCNAMERecordAttributes::fromArray($attrs);
            case self::DNS_MX_RECORD:
                return DnsMXRecordAttributes::fromArray($attrs);
            case self::DNS_SRV_RECORD:
                return DnsSRVRecordAttributes::fromArray($attrs);
            case self::DNS_TXT_RECORD:
                return DnsTXTRecordAttributes::fromArray($attrs);
            case self::DNS_NS_RECORD:
                return DnsNSRecordAttributes::fromArray($attrs);
            default:
                throw new Exception('Invalid DNS type');
        }
    }

    public function setAttrsAttribute(DnsRecordAttributes $value)
    {
        $this->attributes['attrs'] = json_encode($value->toArray());
    }
}
