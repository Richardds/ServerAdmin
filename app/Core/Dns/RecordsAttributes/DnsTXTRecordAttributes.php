<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException;
use Richardds\ServerAdmin\DnsRecord;

class DnsTXTRecordAttributes implements DnsRecordAttributes
{
    protected $content;

    public function __construct($content)
    {
        $this->setContent($content);
    }

    public static function fromArray(array $attributes): DnsRecordAttributes
    {
        if (! array_has($attributes, ['content'])) {
            throw new InvalidParameterException('Cannot create DnsRecordAttributes class from given array', [
                'attributes' => $attributes,
            ]);
        }

        return new self($attributes['content']);
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = (string) ($content ?? '');
    }

    public function toBindSyntax(DnsRecord $dnsRecord): string
    {
        return sprintf("%s\t%d\tIN\tTXT\t\"%s\"", $dnsRecord->name, $dnsRecord->ttl, $this->content);
    }

    public function toArray(): array
    {
        return [
            'content' => $this->content,
        ];
    }
}
