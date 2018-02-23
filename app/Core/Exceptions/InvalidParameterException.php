<?php

namespace Richardds\ServerAdmin\Core\Exceptions;

use Exception;

class InvalidParameterException extends Exception
{
    /**
     * InvalidParameterException constructor.
     *
     * @param string $message
     * @param array $parameters
     */
    public function __construct(string $message = "", array $parameters)
    {
        parent::__construct($message);

        $parametes_str = [];

        foreach ($parameters as $name => $parameter) {
            $parametes_str[] = is_string($name) ? '\'' . $name . '\' => \'' . $parameter . '\'' : '\'' . $parameter . '\'';
        }

        $this->message .= ' (' . implode(', ', $parametes_str) . ')';
    }
}
