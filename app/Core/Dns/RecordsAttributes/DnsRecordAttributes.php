<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Illuminate\Contracts\Support\Arrayable;
use Richardds\ServerAdmin\DnsRecord;

interface DnsRecordAttributes extends Arrayable
{
    public static function fromArray(array $attributes): DnsRecordAttributes;

    public function toBindSyntax(DnsRecord $dnsRecord): string;

    public function toArray(): array;
}
