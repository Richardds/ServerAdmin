<?php

namespace Richardds\ServerAdmin;

use Illuminate\Database\Eloquent\Model;
use Richardds\ServerAdmin\Scopes\Local\Toggles;

/**
 * Richardds\ServerAdmin\SiteSSL
 *
 * @property int $id
 * @property int $site_id
 * @property string $certificate
 * @property string $key
 * @property bool $enabled
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Richardds\ServerAdmin\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\SiteSSL enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\SiteSSL whereCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\SiteSSL whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\SiteSSL whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\SiteSSL whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\SiteSSL whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\SiteSSL whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\SiteSSL whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SiteSSL extends Model
{
    use Toggles;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sites_ssl';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site_id',
        'certificate',
        'key',
        'enabled',
    ];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'site_id',
        'certificate',
        'key',
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
        'site_id' => 'integer',
        'certificate' => 'string',
        'key' => 'string',
        'enabled' => 'boolean',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
