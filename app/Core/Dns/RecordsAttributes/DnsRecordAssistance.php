<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Exception;
use Illuminate\Support\Facades\Validator;
use Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException;
use Richardds\ServerAdmin\DnsRecord;

trait DnsRecordAssistance
{
    /**
     * @param array $attributes
     * @param array $rules
     * @throws InvalidParameterException
     */
    public static function validateDnsRecordAttributes(array $attributes, array $rules)
    {
        if (Validator::make($attributes, $rules)->fails()) {
            throw new InvalidParameterException(
                'Cannot create ' . class_basename(__CLASS__). ' class from given array', $attributes
            );
        }
    }

    /**
     * @param string $type
     * @param array $attrs
     * @return DnsRecordAttributes
     * @throws Exception
     */
    public static function createDnsRecordAttributes(string $type, array $attrs): DnsRecordAttributes
    {
        switch ($type) {
            case DnsRecord::DNS_A_RECORD:
                return DnsARecordAttributes::fromArray($attrs);
            case DnsRecord::DNS_AAAA_RECORD:
                return DnsAAAARecordAttributes::fromArray($attrs);
            case DnsRecord::DNS_CNAME_RECORD:
                return DnsCNAMERecordAttributes::fromArray($attrs);
            case DnsRecord::DNS_MX_RECORD:
                return DnsMXRecordAttributes::fromArray($attrs);
            case DnsRecord::DNS_SRV_RECORD:
                return DnsSRVRecordAttributes::fromArray($attrs);
            case DnsRecord::DNS_TXT_RECORD:
                return DnsTXTRecordAttributes::fromArray($attrs);
            case DnsRecord::DNS_NS_RECORD:
                return DnsNSRecordAttributes::fromArray($attrs);
            default:
                throw new Exception('Invalid DNS type');
        }
    }
}
