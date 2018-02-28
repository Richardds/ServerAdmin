<?php

use Carbon\Carbon;
use Richardds\ServerAdmin\Http\ApiResponse;

/**
 * Return application version.
 *
 * @return string
 */
function version(): string
{
    return env('APP_VERSION', '0.0.0');
}

/**
 * @param \Carbon\Carbon $date
 * @return string
 */
function formatDate(Carbon $date): string
{
    return $date->format('j. F Y');
}

/**
 * @param \Carbon\Carbon $datetime
 * @return string
 */
function formatDatetime(Carbon $datetime): string
{
    return $datetime->format('j. F Y H:i:s');
}

/**
 * @return \Richardds\ServerAdmin\Http\ApiResponse
 */
function api_response(): ApiResponse
{
    return new ApiResponse();
}

/**
 * @param string $password
 * @param null|string $salt
 * @return string
 */
function sha512crypt(string $password, ?string $salt = null)
{
    if (is_null($salt)) {
        $salt = substr(bin2hex(openssl_random_pseudo_bytes(16)), 0, 16);
    }

    return crypt($password, sprintf('$6$%s$', $salt));
}

/**
 * @param string $string
 * @param int $length
 * @param string $ending
 * @return string
 */
function limitStringLength(string $string, int $length, string $ending = '...'): string
{
    return strlen($string) > $length ? substr($string, 0, $length - strlen($ending)) . $ending : $string;
}

/**
 * @param string $value
 * @param array $rules
 * @param null|string $name
 * @throws \Illuminate\Validation\ValidationException
 */
function validate(string $value, array $rules, ?string $name = 'value'): void
{
    Validator::make([$name => $value], [$name => $rules])->validate();
}
