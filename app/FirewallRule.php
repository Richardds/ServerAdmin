<?php

namespace Richardds\ServerAdmin;

use Illuminate\Database\Eloquent\Model;
use Richardds\ServerAdmin\Scopes\Local\Toggles;

/**
 * Richardds\ServerAdmin\FirewallRule
 *
 * @property int $id
 * @property string $type
 * @property string $protocol
 * @property string $destination
 * @property string $source
 * @property int $port
 * @property int $portTo
 * @property bool $enabled
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\FirewallRule enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\FirewallRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\FirewallRule whereDestination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\FirewallRule whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\FirewallRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\FirewallRule wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\FirewallRule wherePortTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\FirewallRule whereProtocol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\FirewallRule whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\FirewallRule whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\FirewallRule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FirewallRule extends Model
{
    use Toggles;

    const TYPE_ALLOW = 'allow';

    const TYPE_DENY = 'deny';

    const TYPE_REJECT = 'reject';

    const TYPE_LIMIT = 'limit';

    const PROTOCOL_TCP = 'tcp';

    const PROTOCOL_UDP = 'udp';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'protocol',
        'destination',
        'source',
        'port',
        'portTo',
        'enabled',
    ];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'type',
        'protocol',
        'destination',
        'source',
        'port',
        'portTo',
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
        'type' => 'string',
        'protocol' => 'string',
        'destination' => 'string',
        'source' => 'string',
        'port' => 'integer',
        'portTo' => 'integer',
        'enabled' => 'boolean',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    public static function availableTypes()
    {
        return [
            self::TYPE_ALLOW,
            self::TYPE_DENY,
            self::TYPE_REJECT,
            self::TYPE_LIMIT,
        ];
    }

    public static function availableProtocols()
    {
        return [
            self::PROTOCOL_TCP,
            self::PROTOCOL_UDP,
        ];
    }
}
