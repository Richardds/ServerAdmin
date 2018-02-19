<?php

namespace Richardds\ServerAdmin\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * IP address with network validation rule.
 *
 * Class IPN
 * @package Richardds\ServerAdmin\Rules
 */
class IPN implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Use 'required' rule if attribute is not optional.
        if (empty($value)) {
            return true;
        }

        $ip = $value;
        $network = 32;

        // Check if IP address contains network prefix information.
        if (strpos($value, '/') !== false) {
            $ip_parts = explode('/', $value);

            if (count($ip_parts) !== 2) {
                return false;
            }

            $ip = $ip_parts[0];
            $network = $ip_parts[1];
        }

        $ipv4 = (false !== filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4));

        if (!$ipv4 && false === filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return false;
        }

        // Validate network prefix length.
        if (!is_numeric($network) || $network < 0 || $network > ($ipv4 ? 32 : 128)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.ipn');
    }
}
