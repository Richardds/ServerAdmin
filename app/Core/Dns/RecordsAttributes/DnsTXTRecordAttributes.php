<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\DnsRecord;

class DnsTXTRecordAttributes implements DnsRecordAttributes
{
    use DnsRecordAssistance;

    /**
     * @var
     */
    protected $content;

    /**
     * DnsTXTRecordAttributes constructor.
     * @param $content
     */
    public function __construct($content)
    {
        $this->setContent($content);
    }

    /**
     * @param array $attributes
     * @return DnsRecordAttributes
     * @throws \Richardds\ServerAdmin\Core\Exceptions\InvalidValidatedParameterException
     */
    public static function fromArray(array $attributes): DnsRecordAttributes
    {
        self::validateDnsRecordAttributes($attributes, [
            'content' => 'required|min:1|max:255'
        ]);

        return new self($attributes['content']);
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = (string) ($content ?? '');
    }

    /**
     * @param DnsRecord $dnsRecord
     * @return string
     */
    public function toBindSyntax(DnsRecord $dnsRecord): string
    {
        return sprintf("%s\t%d\tIN\tTXT\t\"%s\"", $dnsRecord->name, $dnsRecord->ttl, $this->content);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'content' => $this->content,
        ];
    }
}
