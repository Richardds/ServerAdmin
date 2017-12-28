<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\DnsRecord;

class DnsSRVRecordAttributes implements DnsRecordAttributes
{
    use DnsRecordAssistance;

    /**
     * @var string
     */
    protected $service;

    /**
     * @var string
     */
    protected $protocol;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var int
     */
    protected $priority;

    /**
     * @var int
     */
    protected $weight;

    /**
     * @var int
     */
    protected $port;

    /**
     * DnsSRVRecordAttributes constructor.
     * @param string $service
     * @param string $protocol
     * @param string $host
     * @param int $priority
     * @param int $weight
     * @param int $port
     */
    public function __construct(string $service, string $protocol, string $host, int $priority, int $weight, int $port)
    {
        $this->service = $service;
        $this->protocol = $protocol;
        $this->host = $host;
        $this->priority = $priority;
        $this->weight = $weight;
        $this->port = $port;
    }

    /**
     * @param array $attributes
     * @return DnsRecordAttributes
     * @throws \Richardds\ServerAdmin\Core\Exceptions\InvalidValidatedParameterException
     */
    public static function fromArray(array $attributes): DnsRecordAttributes
    {
        self::validateDnsRecordAttributes($attributes, [
            'service' => 'required|min:1|max:50',
            'protocol' => 'required|min:1|max:50',
            'host' => 'required|min:1|max:253',
            'priority' => 'required|numeric',
            'weight' => 'required|numeric',
            'port' => 'required|numeric',
        ]);

        return new self($attributes['service'], $attributes['protocol'], $attributes['host'], $attributes['priority'], $attributes['weight'], $attributes['port']);
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * @param string $service
     */
    public function setService(string $service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->protocol;
    }

    /**
     * @param string $protocol
     */
    public function setProtocol(string $protocol)
    {
        $this->protocol = $protocol;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host)
    {
        $this->host = $host;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority(int $priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight(int $weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port)
    {
        $this->port = $port;
    }

    /**
     * @param DnsRecord $dnsRecord
     * @return string
     */
    public function toBindSyntax(DnsRecord $dnsRecord): string
    {
        return sprintf("%s.%s.%s\t%d\tIN\tSRV\t%d\t%d\t%d\t%s", $this->service, $this->protocol, $dnsRecord->name, $dnsRecord->ttl, $this->priority, $this->weight, $this->port, $this->host);
    }

    /**
     * @return array
     */
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
