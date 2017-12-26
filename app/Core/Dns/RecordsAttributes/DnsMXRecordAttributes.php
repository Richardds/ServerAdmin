<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\DnsRecord;

class DnsMXRecordAttributes implements DnsRecordAttributes
{
    use DnsRecordAssistance;

    protected $host;

    protected $priority;

    public function __construct(string $host, int $priority)
    {
        $this->host = $host;
        $this->priority = $priority;
    }

    public static function fromArray(array $attributes): DnsRecordAttributes
    {
        self::validateDnsRecordAttributes($attributes, [
            'host' => 'required|min:1|max:253',
            'priority' => 'required|numeric'
        ]);

        return new self($attributes['host'], $attributes['priority']);
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host)
    {
        $this->host = $host;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority)
    {
        $this->priority = $priority;
    }

    public function toBindSyntax(DnsRecord $dnsRecord): string
    {
        return sprintf("%s\t%d\tIN\tMX\t%d\t%s", $dnsRecord->name, $dnsRecord->ttl, $this->priority, $this->host);
    }

    public function toArray(): array
    {
        return [
            'host' => $this->host,
            'priority' => $this->priority,
        ];
    }
}
