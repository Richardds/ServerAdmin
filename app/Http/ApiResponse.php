<?php

namespace Richardds\ServerAdmin\Http;

use Exception;
use Illuminate\Support\Arr;

class ApiResponse
{
    /**
     * @var boolean
     */
    protected $success;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var Exception
     */
    protected $exception;

    /**
     * @var array
     */
    protected $errors;

    /**
     * @param array $data
     * @return $this
     */
    public function success(array $data = null)
    {
        $this->success = true;
        $this->data = $data;

        return $this;
    }

    /**
     * @param \Exception|null $e
     * @return $this
     */
    public function fail(Exception $e = null)
    {
        $this->success = false;

        if (! is_null($e)) {
            $this->exception($e);
        }

        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function message(string $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function payload(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param \Exception $e
     * @return $this
     */
    public function exception(Exception $e)
    {
        if (empty($this->message)) {
            $this->message = $e->getMessage();
        }

        $this->exception = $e;

        return $this;
    }

    /**
     * @param array $errors
     * @return $this
     */
    public function errors(array $errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @param int $status
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(int $status = 200, array $headers = [])
    {
        $responseData = [
            'success' => $this->success ?? true,
        ];

        if (! empty($this->message)) {
            $responseData['message'] = $this->message;
        }

        if (! empty($this->data)) {
            $responseData['data'] = $this->data;
        }

        if (! is_null($this->exception)) {
            $responseData['exception'] = [
                'message' => $this->exception->getMessage(),
                'class' => get_class($this->exception),
                'file' => $this->exception->getFile(),
                'line' => $this->exception->getLine(),
                'trace' => collect($this->exception->getTrace())->map(function ($trace) {
                    return Arr::except($trace, ['args']);
                })->all(),
            ];
        }

        return response()->json($responseData, $status, $headers, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
