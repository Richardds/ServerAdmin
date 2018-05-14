<?php

namespace Richardds\ServerAdmin\Core\Sites;

use DB;
use Illuminate\Support\Facades\View;
use Richardds\ServerAdmin\Core\Commands\Command;
use Richardds\ServerAdmin\Core\ConfigIo;
use Richardds\ServerAdmin\Core\ConfigurableService;
use Richardds\ServerAdmin\Core\Service;
use Richardds\ServerAdmin\Facades\Execute;
use Richardds\ServerAdmin\Site;
use Symfony\Component\Finder\Finder;

class SitesManager extends Service implements ConfigurableService
{
    const SITES_CONFIG_FOLDER_ENABLED = '/etc/nginx/sites-enabled';

    public function __construct()
    {
        parent::__construct('nginx');
    }

    public function configure()
    {
        $sites = Site::withSslAll();

        foreach ($sites as $site) {
            $siteConfig = new ConfigIo(self::SITES_CONFIG_FOLDER_ENABLED . "/{$site['name']}.conf");
            $siteConfig->truncate();

            $listen = $site['ssl_enabled'] ? '443 ssl' : '80';

            $siteConfig->writeln("server {");
            $siteConfig->writeln("listen {$listen};");
            $siteConfig->writeln("server_name {$site['name']};");
            $siteConfig->writeln("root /var/www/{$site['name']}/public;");

            if ($site['ssl_enabled']) {
                $siteConfig->writeln("ssl_certificate {$site['ssl_certificate']};");
                $siteConfig->writeln("ssl_certificate_key {$site['ssl_key']};");
            }

            $siteConfig->writeln("location / {");
            $siteConfig->writeln("try_files \$uri \$uri/index.html =404;");
            $siteConfig->writeln("}");

            if ($site['php_enabled']) {
                $siteConfig->writeln("location ~ \.php$ {");
                $siteConfig->writeln("include fastcgi_params;");
                $siteConfig->writeln("fastcgi_pass php-handler;");
                $siteConfig->writeln("fastcgi_index index.php;");
                $siteConfig->writeln("fastcgi_param SCRIPT_FILENAME \$document_root/\$fastcgi_script_name;");
                $siteConfig->writeln("}");
            }

            $siteConfig->writeln("access_log /var/www/{$site['name']}/logs/nginx_access.log;");
            $siteConfig->writeln("error_log /var/www/{$site['name']}/logs/nginx_error.log;");

            $siteConfig->writeln("}");

            Execute::withoutOutput("mkdir -p /var/www/{$site['name']}/public /var/www/{$site['name']}/logs", true);
            Execute::withoutOutput("chown www-data:www-data -R /var/www/{$site['name']}", true);
        }

        $this->cleanSitesFiles();
    }

    public function cleanSitesFiles()
    {
        $finder = new Finder();
        $files = $finder->files()->in(self::SITES_CONFIG_FOLDER_ENABLED);
        $exceptions = array_merge(explode(',', env('SITES_CONFIG_EXCEPTION', '')), ['serveradmin.conf']);

        $filenames = Site::enabled()->get([DB::raw('CONCAT(name, \'.conf\') AS filename')])->pluck('filename');

        foreach ($files->getIterator() as $file) {
            if (!$filenames->contains($file->getFilename()) && !in_array($file->getFilename(), $exceptions)) {
                Execute::withoutOutput("rm {$file->getRealPath()}", true);
            }
        }
    }

    public function makeDemoWebsite(Site $site)
    {
        $filename = "/var/www/{$site->name}/public/index.html";

        Execute::withoutOutput(Command::create("cat >> {$filename}",
            View::make('others.demo', compact('site'))->render()), true);
        Execute::withoutOutput("chown www-data:www-data {$filename}", true);
    }
}
