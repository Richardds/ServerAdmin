<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\DnsRecord;

class DnsCNAMERecordAttributes implements DnsRecordAttributes
{
    use DnsRecordAssistance;

    /**
     * @var string
     */
    protected $host;

    /**
     * DnsCNAMERecordAttributes constructor.
     * @param string $host
     */
    public function __construct(string $host)
    {
        $this->host = $host;
    }

    /**
     * @param array $attributes
     * @return DnsRecordAttributes
     * @throws \Richardds\ServerAdmin\Core\Exceptions\InvalidValidatedParameterException
     */
    public static function fromArray(array $attributes): DnsRecordAttributes
    {
        self::validateDnsRecordAttributes($attributes, [
            'host' => 'required|min:1|max:253'
        ]);

        return new self($attributes['host']);
    }

    /**
     * @return string
     */
    public function getHost()
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
     * @param DnsRecord $dnsRecord
     * @return string
     */
    public function toBindSyntax(DnsRecord $dnsRecord): string
    {
        return sprintf("%s\t%d\tIN\tCNAME\t%s.", $dnsRecord->name, $dnsRecord->ttl, $this->host);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'host' => $this->host,
        ];
    }
}
