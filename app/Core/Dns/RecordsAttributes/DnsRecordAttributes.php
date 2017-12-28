<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Illuminate\Contracts\Support\Arrayable;
use Richardds\ServerAdmin\DnsRecord;

interface DnsRecordAttributes extends Arrayable
{
    /**
     * @param array $attributes
     * @return DnsRecordAttributes
     */
    public static function fromArray(array $attributes): DnsRecordAttributes;

    /**
     * @param DnsRecord $dnsRecord
     * @return string
     */
    public function toBindSyntax(DnsRecord $dnsRecord): string;

    /**
     * @return array
     */
    public function toArray(): array;
}
