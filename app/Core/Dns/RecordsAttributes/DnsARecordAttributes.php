<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\Core\Dns\DnsAttributesException;
use Richardds\ServerAdmin\DnsRecord;

class DnsARecordAttributes implements DnsRecordAttributes
{
    protected $ipv4;

    public function __construct(string $ipv4)
    {
        $this->ipv4 = $ipv4;
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

    public static function fromArray(array $attributes): DnsRecordAttributes
    {
        if (! array_has($attributes, ['ipv4'])) {
            throw new DnsAttributesException('Cannot create DnsRecordAttributes class from given array');
        }

        return new self($attributes['ipv4']);
    }
}
