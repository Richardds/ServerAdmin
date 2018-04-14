<?php

namespace Richardds\ServerAdmin;

use Illuminate\Database\Eloquent\Model;
use Richardds\ServerAdmin\Scopes\Local\Toggles;

/**
 * Richardds\ServerAdmin\Site
 *
 * @property int $id
 * @property string $name
 * @property bool $php_enabled
 * @property bool $enabled
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Richardds\ServerAdmin\SiteSSL $ssl
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\Site enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\Site whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\Site whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\Site whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\Site whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\Site wherePhpEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Richardds\ServerAdmin\Site whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Site extends Model
{
    use Toggles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'php_enabled',
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
        'php_enabled',
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
        'php_enabled' => 'boolean',
        'enabled' => 'boolean',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    /**
     * @param int|null $id
     * @return array
     */
    public static function withSsl(int $id): array
    {
        $site = Site::findOrFail($id);
        $site_array = $site->toArray();
        $ssl = $site->ssl;

        if (!is_null($ssl)) {
            $site_array['ssl_enabled'] = $ssl->enabled;
            $site_array['ssl_certificate'] = $ssl->certificate;
            $site_array['ssl_key'] = $ssl->key;
        }

        return $site_array;
    }

    /**
     * @return array
     */
    public static function withSslAll(): array
    {
        $sites = [];

        foreach (Site::all() as $site) {
            $sites[] = self::withSsl($site->id);
        }

        return $sites;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ssl()
    {
        return $this->hasOne(SiteSSL::class);
    }
}
