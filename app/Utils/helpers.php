<?php

use Carbon\Carbon;
use Richardds\ServerAdmin\Http\ApiResponse;

function formatDate(Carbon $date)
{
    return $date->format('j. F Y');
}

function formatDatetime(Carbon $datetime)
{
    return $datetime->format('j. F Y H:i:s');
}

function api_response()
{
    return new ApiResponse();
}
