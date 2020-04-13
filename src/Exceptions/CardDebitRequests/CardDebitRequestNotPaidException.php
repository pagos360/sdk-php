<?php

namespace Pagos360\Exceptions\CardDebitRequests;

use Pagos360\Exceptions\AbstractException;
use Pagos360\Models\CardDebitRequest;
use Throwable;

class CardDebitRequestNotPaidException extends AbstractException
{
    /**
     * @var CardDebitRequest
     */
    private $cardDebitRequest;

    /**
     * @param CardDebitRequest $cardDebitRequest
     * @param Throwable|null   $previous
     */
    public function __construct(
        CardDebitRequest $cardDebitRequest,
        Throwable $previous = null
    ) {
        $this->cardDebitRequest = $cardDebitRequest;
        $data = [
            'cardDebitRequest' => $cardDebitRequest,
        ];

        parent::__construct($data, $previous);
    }

    /**
     * @return CardDebitRequest
     */
    public function getCardDebitRequest(): CardDebitRequest
    {
        return $this->cardDebitRequest;
    }
}
