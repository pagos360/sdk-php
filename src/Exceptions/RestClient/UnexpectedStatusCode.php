<?php

namespace Pagos360\Exceptions\RestClient;

use Pagos360\Exceptions\AbstractException;
use Throwable;

class UnexpectedStatusCode extends AbstractException
{
    /**
     * @var string
     */
    public $message;

    /**
     * @var int
     */
    private $expectedStatusCode;

    /**
     * @var int
     */
    private $actualStatusCode;

    /**
     * @param int            $expectedStatusCode
     * @param int            $actualStatusCode
     * @param Throwable|null $previous
     * @todo add guzzle info (like headers) and the body response
     */
    public function __construct(
        int $expectedStatusCode,
        int $actualStatusCode,
        Throwable $previous = null
    ) {
        $data = [
            'expected' => $expectedStatusCode,
            'actual' => $actualStatusCode,
        ];
        $this->expectedStatusCode = $expectedStatusCode;
        $this->actualStatusCode = $actualStatusCode;

        $this->message = sprintf(
            'Unexpected status code %s. Was expecting %s.',
            $actualStatusCode,
            $expectedStatusCode
        );

        parent::__construct($data, $previous);
    }

    /**
     * @return int
     */
    public function getExpectedStatusCode(): int
    {
        return $this->expectedStatusCode;
    }

    /**
     * @return int
     */
    public function getActualStatusCode(): int
    {
        return $this->actualStatusCode;
    }
}
