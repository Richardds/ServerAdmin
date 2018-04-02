<?php

namespace Richardds\ServerAdmin\Core\Sites;

use Richardds\ServerAdmin\Core\ConfigurableService;
use Richardds\ServerAdmin\Core\Service;
use Richardds\ServerAdmin\Site;

class SitesManager extends Service implements ConfigurableService
{
    const SITES_CONFIG_FOLDER_ENABLED = '/etc/nginx/sites-enabled';
    const ZONES_CONFIG_FOLDER_AVAILABLE = '/etc/nginx/sites-available';

    public function __construct()
    {
        parent::__construct('nginx');
    }

    public function configure()
    {
        $sites = Site::allWithSSL();

        foreach ($sites as $site) {
            // TODO: Write config
        }
    }
}
