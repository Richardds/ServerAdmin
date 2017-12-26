<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\DnsRecord;

class DnsARecordAttributes implements DnsRecordAttributes
{
    use DnsRecordAssistance;

    protected $ipv4;

    public function __construct(string $ipv4)
    {
        $this->ipv4 = $ipv4;
    }

    public static function fromArray(array $attributes): DnsRecordAttributes
    {
        self::validateDnsRecordAttributes($attributes, [
            'ipv4' => 'required|ipv4'
        ]);

        return new self($attributes['ipv4']);
    }

    public function getIpv4()
    {
        return $this->ipv4;
    }

    public function setIpv4(string $ipv4)
    {
        $this->ipv4 = $ipv4;
    }

    public function toBindSyntax(DnsRecord $dnsRecord): string
    {
        return sprintf("%s\t%d\tIN\tA\t%s", $dnsRecord->name, $dnsRecord->ttl, $this->ipv4);
    }

    public function toArray(): array
    {
        return [
            'ipv4' => $this->ipv4,
        ];
    }
}
