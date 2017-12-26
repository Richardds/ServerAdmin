<?php

namespace Richardds\ServerAdmin\Core\Dns\RecordsAttributes;

use Illuminate\Support\Facades\Validator;
use Richardds\ServerAdmin\Core\Exceptions\InvalidParameterException;

trait DnsRecordAssistance
{
    /**
     * @param array $attributes
     * @param array $rules
     * @throws InvalidParameterException
     */
    public static function validate(array $attributes, array $rules)
    {
        if (Validator::make($attributes, $rules)->fails()) {
            throw new InvalidParameterException(
                'Cannot create ' . class_basename(__CLASS__). ' class from given array', $attributes
            );
        }
    }
}
