<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\DnsRecord;

class DnsCNAMERecordAttributes implements DnsRecordAttributes
{
    use DnsRecordAssistance;

    protected $host;

    public function __construct(string $host)
    {
        $this->host = $host;
    }

    public static function fromArray(array $attributes): DnsRecordAttributes
    {
        self::validateDnsRecordAttributes($attributes, [
            'host' => 'required|min:1|max:253'
        ]);

        return new self($attributes['host']);
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setHost(string $host)
    {
        $this->host = $host;
    }

    public function toBindSyntax(DnsRecord $dnsRecord): string
    {
        return sprintf("%s\t%d\tIN\tCNAME\t%s", $dnsRecord->name, $dnsRecord->ttl, $this->host);
    }

    public function toArray(): array
    {
        return [
            'host' => $this->host,
        ];
    }
}
