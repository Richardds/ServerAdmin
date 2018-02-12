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
