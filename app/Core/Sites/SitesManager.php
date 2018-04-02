<?php

namespace Richardds\ServerAdmin\Core\Sites;

use Richardds\ServerAdmin\Core\ConfigurableService;
use Richardds\ServerAdmin\Core\Service;

class SitesManager extends Service implements ConfigurableService
{

    public function __construct()
    {
        parent::__construct('nginx');
    }

    public function configure()
    {
        // TODO: Configure nginx
    }
}
