<?php

namespace Pagos360\Exceptions\DebitRequests;

use Pagos360\Exceptions\AbstractException;
use Pagos360\Models\DebitRequest;
use Throwable;

class DebitRequestNotPaidException extends AbstractException
{
    /**
     * @var DebitRequest
     */
    private $debitRequest;

    /**
     * @param DebitRequest   $debitRequest
     * @param Throwable|null $previous
     */
    public function __construct(
        DebitRequest $debitRequest,
        Throwable $previous = null
    ) {
        $this->debitRequest = $debitRequest;
        $data = [
            'debitRequest' => $debitRequest,
        ];

        parent::__construct($data, $previous);
    }

    /**
     * @return DebitRequest
     */
    public function getDebitRequest(): DebitRequest
    {
        return $this->debitRequest;
    }
}
