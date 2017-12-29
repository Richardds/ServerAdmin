<?php

namespace Richardds\ServerAdmin;

use Illuminate\Database\Eloquent\Model;
use Richardds\ServerAdmin\Core\Cron\CronInterval;

/**
 * Richardds\ServerAdmin\Cron
 *
 * @property int $id
 * @property CronInterval $interval
 * @property string $command
 * @property int $uid
 * @property bool $enabled
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\Cron whereCommand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\Cron whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\Cron whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\Cron whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\Cron whereInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\Cron whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\Cron whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Cron extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'interval',
        'command',
        'uid',
        'enabled',
    ];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = [
        'interval',
        'command',
        'uid',
        'enabled',
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
        'command' => 'string',
        'uid' => 'integer',
        'enabled' => 'boolean',
    ];

    /**
     * @param CronInterval $interval
     */
    protected function setIntervalAttribute(CronInterval $interval): void
    {
        $this->attributes['interval'] = (string)$interval;
    }

    /**
     * @param string $value
     * @return CronInterval
     * @throws Core\Exceptions\InvalidParameterException
     */
    protected function getIntervalAttribute(string $value): CronInterval
    {
        return CronInterval::fromString($value);
    }
}
