<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException;
use Richardds\ServerAdmin\DnsRecord;

class DnsSRVRecordAttributes implements DnsRecordAttributes
{
    protected $service;

    protected $protocol;

    protected $host;

    protected $priority;

    protected $weight;

    protected $port;

    public function __construct(string $service, string $protocol, string $host, int $priority, int $weight, int $port)
    {
        $this->service = $service;
        $this->protocol = $protocol;
        $this->host = $host;
        $this->priority = $priority;
        $this->weight = $weight;
        $this->port = $port;
    }

    public static function fromArray(array $attributes): DnsRecordAttributes
    {
        if (! array_has($attributes, ['service', 'protocol', 'host', 'priority', 'weight', 'port'])) {
            throw new InvalidParameterException('Cannot create DnsRecordAttributes class from given array', [
                'attributes' => $attributes,
            ]);
        }

        return new self($attributes['service'], $attributes['protocol'], $attributes['host'], $attributes['priority'], $attributes['weight'], $attributes['port']);
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function setService(string $service)
    {
        $this->service = $service;
    }

    public function getProtocol(): string
    {
        return $this->protocol;
    }

    public function setProtocol(string $protocol)
    {
        $this->protocol = $protocol;
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

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setWeight(int $weight)
    {
        $this->weight = $weight;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function setPort(int $port)
    {
        $this->port = $port;
    }

    public function toBindSyntax(DnsRecord $dnsRecord): string
    {
        return sprintf("%s.%s.%s\t%d\tIN\tSRV\t%d\t%d\t%d\t%s", $this->service, $this->protocol, $dnsRecord->name, $dnsRecord->ttl, $this->priority, $this->weight, $this->port, $this->host);
    }

    public function toArray(): array
    {
        return [
            'service' => $this->service,
            'protocol' => $this->protocol,
            'host' => $this->host,
            'priority' => $this->priority,
            'weight' => $this->weight,
            'port' => $this->port,
        ];
    }
}
