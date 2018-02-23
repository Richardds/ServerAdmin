<?php

namespace Richardds\ServerAdmin\Core\Exceptions;

use Exception;

class InvalidCommandOutputException extends Exception
{
    private const MAX_STRING_LENGTH = 30;

    /**
     * InvalidCommandOutputException constructor.
     *
     * @param string $message
     * @param string $output
     */
    public function __construct(string $message = "", string $output)
    {
        parent::__construct($message . ' (' . limitStringLength($output, self::MAX_STRING_LENGTH) . ')');
    }
}
