<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\DnsRecord;

class DnsNSRecordAttributes implements DnsRecordAttributes
{
    use DnsRecordAssistance;

    protected $nameserver;

    public function __construct(string $nameserver)
    {
        $this->nameserver = $nameserver;
    }

    public static function fromArray(array $attributes): DnsRecordAttributes
    {
        self::validateDnsRecordAttributes($attributes, [
            'nameserver' => 'required|min:1|max:253'
        ]);

        return new self($attributes['nameserver']);
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
}
