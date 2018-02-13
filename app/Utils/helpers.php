<?php

use Carbon\Carbon;
use Richardds\ServerAdmin\Http\ApiResponse;

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
