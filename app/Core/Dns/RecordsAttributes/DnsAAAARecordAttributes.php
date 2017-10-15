<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException;
use Richardds\ServerAdmin\DnsRecord;

class DnsAAAARecordAttributes implements DnsRecordAttributes
{
    protected $ipv6;

    public function __construct(string $ipv6)
    {
        $this->ipv6 = $ipv6;
    }

    public static function fromArray(array $attributes): DnsRecordAttributes
    {
        if (! array_has($attributes, ['ipv6'])) {
            throw new InvalidParameterException('Cannot create DnsRecordAttributes class from given array', [
                'attributes' => $attributes,
            ]);
        }

        return new self($attributes['ipv6']);
    }

    public function getIpv6()
    {
        return $this->ipv6;
    }

    public function setIpv6(string $ipv6)
    {
        $this->ipv6 = $ipv6;
    }

    public function toBindSyntax(DnsRecord $dnsRecord): string
    {
        return sprintf("%s\t%d\tIN\tAAAA\t%s", $dnsRecord->name, $dnsRecord->ttl, $this->ipv6);
    }

    public function toArray(): array
    {
        return [
            'ipv6' => $this->ipv6,
        ];
    }
}
