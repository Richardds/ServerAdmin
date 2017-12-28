<?php

namespace Richardds\ServerAdmin\Core\Exceptions;

use Illuminate\Validation\Validator;

class InvalidValidatedParameterException extends InvalidParameterException
{
    protected $errors;

    public function __construct(string $message = "", array $parameters, Validator $validator)
    {
        parent::__construct($message, $parameters);
        $this->errors = $validator->messages()->toArray();
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }
}
