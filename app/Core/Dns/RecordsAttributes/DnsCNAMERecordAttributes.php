<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException;
use Richardds\ServerAdmin\DnsRecord;

class DnsCNAMERecordAttributes implements DnsRecordAttributes
{
    protected $host;

    public function __construct(string $host)
    {
        $this->host = $host;
    }

    public static function fromArray(array $attributes): DnsRecordAttributes
    {
        if (! array_has($attributes, ['host'])) {
            throw new InvalidParameterException('Cannot create DnsRecordAttributes class from given array', [
                'attributes' => $attributes,
            ]);
        }

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
