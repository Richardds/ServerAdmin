<?php

namespace Richardds\ServerAdmin\Core\Dns;

use Richardds\ServerAdmin\Core\ConfigIo;
use Richardds\ServerAdmin\DnsZone;

class Manager
{
    protected $zonesConfigMasterFile = '/etc/bind/named.conf.local';
    protected $zonesConfigFolder = '/etc/bind/zones';

    public function updateZones()
    {
        $zones = DnsZone::whereEnabled(true)->get();
        $configIo = new ConfigIo($this->zonesConfigMasterFile);

        $configIo->truncate();
        $configIo->writeln("include \"/etc/bind/zones.rfc1918\";"); // TODO
        $configIo->nextline();

        foreach ($zones as $zone) {
            $configIo->writeln("zone \"{$zone->name}\" in {");
            $configIo->writeln("\ttype master;");
            $configIo->writeln("\tfile \"{$this->zonesConfigFolder}/{$zone->name}.db\";");
            $configIo->writeln("};");
            $configIo->nextline();

            //$this->updateZoneRecords($zone);
        }
    }

    public function updateZoneRecords(DnsZone $zone)
    {
        $zoneRecords = $zone->dnsRecords;

        foreach ($zoneRecords as $record) {
            $bindRecordConfig = $record->attrs->toBindSyntax($record);
        }
    }
}
