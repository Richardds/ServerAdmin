<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\DnsRecord;

class DnsAAAARecordAttributes implements DnsRecordAttributes
{
    use DnsRecordAssistance;

    /**
     * @var string
     */
    protected $ipv6;

    /**
     * DnsAAAARecordAttributes constructor.
     * @param string $ipv6
     */
    public function __construct(string $ipv6)
    {
        $this->ipv6 = $ipv6;
    }

    /**
     * @param array $attributes
     * @return DnsRecordAttributes
     * @throws \Richardds\ServerAdmin\Core\Exceptions\InvalidValidatedParameterException
     */
    public static function fromArray(array $attributes): DnsRecordAttributes
    {
        self::validateDnsRecordAttributes($attributes, [
            'ipv6' => 'required|ipv6'
        ]);

        return new self($attributes['ipv6']);
    }

    /**
     * @return string
     */
    public function getIpv6()
    {
        return $this->ipv6;
    }

    /**
     * @param string $ipv6
     */
    public function setIpv6(string $ipv6)
    {
        $this->ipv6 = $ipv6;
    }

    /**
     * @param DnsRecord $dnsRecord
     * @return string
     */
    public function toBindSyntax(DnsRecord $dnsRecord): string
    {
        return sprintf("%s\t%d\tIN\tAAAA\t%s", $dnsRecord->name, $dnsRecord->ttl, $this->ipv6);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ipv6' => $this->ipv6,
        ];
    }
}
