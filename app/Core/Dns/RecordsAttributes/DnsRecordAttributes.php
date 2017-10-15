<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Richardds\ServerAdmin\DnsRecord;

interface DnsRecordAttributes
{
    public static function fromArray(array $attributes): DnsRecordAttributes;

    public function toBindSyntax(DnsRecord $dnsRecord): string;

    public function toArray(): array;
}
