<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\DnsRecord;

class DnsMXRecordAttributes implements DnsRecordAttributes
{
    use DnsRecordAssistance;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var int
     */
    protected $priority;

    /**
     * DnsMXRecordAttributes constructor.
     * @param string $host
     * @param int $priority
     */
    public function __construct(string $host, int $priority)
    {
        $this->host = $host;
        $this->priority = $priority;
    }

    /**
     * @param array $attributes
     * @return DnsRecordAttributes
     * @throws \Richardds\ServerAdmin\Core\Exceptions\InvalidValidatedParameterException
     */
    public static function fromArray(array $attributes): DnsRecordAttributes
    {
        self::validateDnsRecordAttributes($attributes, [
            'host' => 'required|min:1|max:253',
            'priority' => 'required|numeric'
        ]);

        return new self($attributes['host'], $attributes['priority']);
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
     * @param DnsRecord $dnsRecord
     * @return string
     */
    public function toBindSyntax(DnsRecord $dnsRecord): string
    {
        return sprintf("%s\t%d\tIN\tMX\t%d\t%s", $dnsRecord->name, $dnsRecord->ttl, $this->priority, $this->host);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'host' => $this->host,
            'priority' => $this->priority,
        ];
    }
}
