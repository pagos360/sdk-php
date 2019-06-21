<?php

namespace Pagos360\Exceptions\PaymentRequests;

use Pagos360\Exceptions\AbstractException;
use Pagos360\Models\PaymentRequest;
use Throwable;

class PaymentRequestNotPaidException extends AbstractException
{
    /**
     * @var PaymentRequest
     */
    private $paymentRequest;

    /**
     * @param PaymentRequest $paymentRequest
     * @param Throwable|null $previous
     */
    public function __construct(
        PaymentRequest $paymentRequest,
        Throwable $previous = null
    ) {
        $this->paymentRequest = $paymentRequest;
        $data = [
            'paymentRequest' => $paymentRequest,
        ];

        parent::__construct($data, $previous);
    }

    /**
     * @return PaymentRequest
     */
    public function getPaymentRequest(): PaymentRequest
    {
        return $this->paymentRequest;
    }
}
