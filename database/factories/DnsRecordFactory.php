<?php

use Faker\Generator as Faker;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsAAAARecordAttributes;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsARecordAttributes;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsCNAMERecordAttributes;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsMXRecordAttributes;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsNSRecordAttributes;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsRecordAttributes;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsSRVRecordAttributes;
use Richardds\ServerAdmin\Core\Dns\RecordsAttributes\DnsTXTRecordAttributes;
use Richardds\ServerAdmin\DnsRecord;

/**
 * @var $factory Illuminate\Database\Eloquent\Factory
 */
$factory->define(DnsRecord::class, function (Faker $faker) {
    $type = $faker->randomElement(DnsRecord::availableTypes());

    /**
     * @var $recordAttributes DnsRecordAttributes
     */
    $recordAttributes = null;

    switch ($type) {
        case DnsRecord::DNS_A_RECORD:
            $recordAttributes = new DnsARecordAttributes($faker->ipv4);
            break;
        case DnsRecord::DNS_AAAA_RECORD:
            $recordAttributes = new DnsAAAARecordAttributes($faker->ipv6);
            break;
        case DnsRecord::DNS_CNAME_RECORD:
            $recordAttributes = new DnsCNAMERecordAttributes($faker->domainName);
            break;
        case DnsRecord::DNS_MX_RECORD:
            $recordAttributes = new DnsMXRecordAttributes($faker->domainName, $faker->numberBetween(1, 5) * 10);
            break;
        case DnsRecord::DNS_SRV_RECORD:
            $recordAttributes = new DnsSRVRecordAttributes(
                $faker->randomElement(['_sip', '_ldap', '_ts3', '_cisco-uds', '_collab-edge',]),
                $faker->randomElement(['_tcp', '_udp',]),
                $faker->domainName,
                $faker->numberBetween(1, 5) * 10,
                $faker->numberBetween(1, 5) * 10,
                $faker->numberBetween(1, 65535)
            );
            break;
        case DnsRecord::DNS_TXT_RECORD:
            $recordAttributes = new DnsTXTRecordAttributes($faker->sentence);
            break;
        case DnsRecord::DNS_NS_RECORD:
            $recordAttributes = new DnsNSRecordAttributes($faker->domainName);
            break;
    }

    return [
        'zone_id' => -1, // Must be overwritten by parent factory
        'type' => $type,
        'name' => $faker->domainWord,
        'attrs' => $recordAttributes,
        'ttl' => $faker->numberBetween(1, 16) * 60 * 450, // 7.5, 15, 22.5 minutes ...
    ];
});
