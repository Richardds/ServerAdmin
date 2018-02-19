<?php

namespace Richardds\ServerAdmin\Core\Dns;

use Richardds\ServerAdmin\Core\ConfigIo;
use Richardds\ServerAdmin\Core\Service;
use Richardds\ServerAdmin\DnsZone;

class DnsManager extends Service
{
    const ZONES_CONFIG_MASTER_FILE = '/etc/bind/named.conf.local';

    const ZONES_CONFIG_FOLDER = '/etc/bind/zones';

    public function __construct()
    {
        parent::__construct('bind9');
    }

    public function generateZonesConfig()
    {
        $zones = DnsZone::whereEnabled(true)->get();
        $zonesConfig = new ConfigIo(self::ZONES_CONFIG_MASTER_FILE);

        $zonesConfig->truncate();
        $zonesConfig->writeln("include \"/etc/bind/zones.rfc1918\";");
        $zonesConfig->nextline();

        foreach ($zones as $zone) {
            $zonesConfigPath = self::ZONES_CONFIG_FOLDER . "/{$zone->name}.db";
            $this->generateZoneRecordsConfig($zone, $zonesConfigPath);

            $zonesConfig->writeln("zone \"{$zone->name}\" in {");
            $zonesConfig->writeln("\ttype master;");
            $zonesConfig->writeln("\tfile \"{$zonesConfigPath}\";");
            $zonesConfig->writeln("};");
            $zonesConfig->nextline();
        }
    }

    public function generateZoneRecordsConfig(DnsZone $zone, string $zonesConfigPath)
    {
        $zoneConfig = new ConfigIo($zonesConfigPath);
        $zoneConfig->truncate();

        $zoneConfig->writeln("@	IN	SOA	{$zone->name} {$zone->admin} ({$zone->serial} {$zone->refresh} {$zone->retry} {$zone->expire} {$zone->ttl})");
        $zoneConfig->nextline();
        $zoneConfig->writeln("@	IN	NS	ns.local.");
        $zoneConfig->nextline();

        $zoneRecords = $zone->dnsRecords;

        foreach ($zoneRecords as $record) {
            $bindRecordConfig = $record->attrs->toBindSyntax($record);
            $zoneConfig->writeln($bindRecordConfig);
        }
    }
}
