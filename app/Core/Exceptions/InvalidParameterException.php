<?php

namespace Richardds\ServerAdmin\Core\Exceptions;

use Exception;

class InvalidParameterException extends Exception
{
    public function __construct($message = "", array $parameters)
    {
        parent::__construct($message);
        $parametes_str = [];
        foreach ($parameters as $name => $parameter) {
            $parametes_str[] = is_string($name) ? '\'' . $name . '\' => \'' . $parameter . '\'' : '\'' . $parameter . '\'';
        }
        $this->message .= ' (parameters: ' . implode(', ', $parametes_str) . ')';
    }
}
