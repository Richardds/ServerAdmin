<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\DnsRecord;

class DnsTXTRecordAttributes implements DnsRecordAttributes
{
    use DnsRecordAssistance;

    protected $content;

    public function __construct($content)
    {
        $this->setContent($content);
    }

    public static function fromArray(array $attributes): DnsRecordAttributes
    {
        self::validate($attributes, [
            'content' => 'required|min:1|max:255'
        ]);

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
