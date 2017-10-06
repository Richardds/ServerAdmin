<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\Core\Dns\DnsAttributesException;
use Richardds\ServerAdmin\DnsRecord;

class DnsNSRecordAttributes implements DnsRecordAttributes
{
    protected $nameserver;

    public function __construct(string $nameserver)
    {
        $this->nameserver = $nameserver;
    }

    public function getNameserver(): string
    {
        return $this->nameserver;
    }

    public function setNameserver(string $nameserver)
    {
        $this->nameserver = $nameserver;
    }

    public function toBindSyntax(DnsRecord $dnsRecord): string
    {
        return sprintf("%s\t%d\tIN\tNS\t%s", $dnsRecord->name, $dnsRecord->ttl, $this->nameserver);
    }

    public function toArray(): array
    {
        return [
            'nameserver' => $this->nameserver,
        ];
    }

    public static function fromArray(array $attributes): DnsRecordAttributes
    {
        if (! array_has($attributes, ['nameserver'])) {
            throw new DnsAttributesException('Cannot create DnsRecordAttributes class from given array');
        }

        return new self($attributes['nameserver']);
    }
}
