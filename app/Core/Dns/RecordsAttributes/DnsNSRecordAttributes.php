<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\DnsRecord;

class DnsNSRecordAttributes implements DnsRecordAttributes
{
    use DnsRecordAssistance;

    /**
     * @var string
     */
    protected $nameserver;

    /**
     * DnsNSRecordAttributes constructor.
     * @param string $nameserver
     */
    public function __construct(string $nameserver)
    {
        $this->nameserver = $nameserver;
    }

    /**
     * @param array $attributes
     * @return DnsRecordAttributes
     * @throws \Richardds\ServerAdmin\Core\Exceptions\InvalidValidatedParameterException
     */
    public static function fromArray(array $attributes): DnsRecordAttributes
    {
        self::validateDnsRecordAttributes($attributes, [
            'nameserver' => 'required|min:1|max:253'
        ]);

        return new self($attributes['nameserver']);
    }

    /**
     * @return string
     */
    public function getNameserver(): string
    {
        return $this->nameserver;
    }

    /**
     * @param string $nameserver
     */
    public function setNameserver(string $nameserver)
    {
        $this->nameserver = $nameserver;
    }

    /**
     * @param DnsRecord $dnsRecord
     * @return string
     */
    public function toBindSyntax(DnsRecord $dnsRecord): string
    {
        return sprintf("%s\t%d\tIN\tNS\t%s.", $dnsRecord->name, $dnsRecord->ttl, $this->nameserver);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'nameserver' => $this->nameserver,
        ];
    }
}
