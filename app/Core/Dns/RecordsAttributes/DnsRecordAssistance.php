<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Exception;
use Illuminate\Support\Facades\Validator;
use Richardds\ServerAdmin\Core\Exceptions\InvalidValidatedParameterException;
use Richardds\ServerAdmin\DnsRecord;

trait DnsRecordAssistance
{
    /**
     * @param array $attributes
     * @param array $rules
     * @throws InvalidValidatedParameterException
     */
    public static function validateDnsRecordAttributes(array $attributes, array $rules)
    {
        $validator = Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new InvalidValidatedParameterException(
                'Cannot create ' . class_basename(__CLASS__) . ' class from given array', $attributes, $validator);
        }
    }

    /**
     * @param string $type
     * @param array $attrs
     * @return DnsRecordAttributes
     * @throws Exception
     * @throws InvalidValidatedParameterException
     */
    public static function createDnsRecordAttributes(string $type, array $attrs): DnsRecordAttributes
    {
        switch ($type) {
            case DnsRecord::RECORD_A:
                return DnsARecordAttributes::fromArray($attrs);
            case DnsRecord::RECORD_AAAA:
                return DnsAAAARecordAttributes::fromArray($attrs);
            case DnsRecord::RECORD_CNAME:
                return DnsCNAMERecordAttributes::fromArray($attrs);
            case DnsRecord::RECORD_MX:
                return DnsMXRecordAttributes::fromArray($attrs);
            case DnsRecord::RECORD_SRV:
                return DnsSRVRecordAttributes::fromArray($attrs);
            case DnsRecord::RECORD_TXT:
                return DnsTXTRecordAttributes::fromArray($attrs);
            case DnsRecord::RECORD_NS:
                return DnsNSRecordAttributes::fromArray($attrs);
            default:
                throw new Exception('Invalid DNS type');
        }
    }
}
