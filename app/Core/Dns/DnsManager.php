<?php

namespace Richardds\ServerAdmin\Core\Dns;

use Richardds\ServerAdmin\Core\ConfigIo;
use Richardds\ServerAdmin\Core\Service;
use Richardds\ServerAdmin\DnsZone;

class DnsManager extends Service
{
    protected $zonesConfigMasterFile = '/etc/bind/named.conf.local';

    protected $zonesConfigFolder = '/etc/bind/zones';

    public function __construct()
    {
        parent::__construct('bind9');
    }

    public function updateZonesConfig()
    {
        $zones = DnsZone::whereEnabled(true)->get();
        $zonesConfig = new ConfigIo($this->zonesConfigMasterFile);

        $zonesConfig->truncate();
        $zonesConfig->writeln("include \"/etc/bind/zones.rfc1918\";"); // TODO
        $zonesConfig->nextline();

        foreach ($zones as $zone) {
            $zonesConfigPath = "{$this->zonesConfigFolder}/{$zone->name}.db";
            $this->updateZoneRecordsConfig($zone, $zonesConfigPath);

            $zonesConfig->writeln("zone \"{$zone->name}\" in {");
            $zonesConfig->writeln("\ttype master;");
            $zonesConfig->writeln("\tfile \"{$zonesConfigPath}\";");
            $zonesConfig->writeln("};");
            $zonesConfig->nextline();
        }
    }

    public function updateZoneRecordsConfig(DnsZone $zone, string $zonesConfigPath)
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
