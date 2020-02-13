<?php

namespace Tests\Repositories;

use Doctrine\Common\Collections\ArrayCollection;
use Pagos360\Models\PaymentRequest;
use Pagos360\Models\Result;
use Pagos360\Repositories\PaymentRequestRepository;
use Tests\AbstractTestCase;

class PaymentRequestRepositoryTest extends AbstractTestCase
{
    /**
     * @var array
     */
    private $mockedResponse = [
        'id' => 1,
        'type' => "payment_request",
        'state' => "paid",
        'created_at' => "2018-01-16T17:26:39-03:00",
        'payer_name' => "Lorem Ipsum",
        'payer_email' => "no-reply@pagos360.com",
        'description' => "Minim consequat pariatur sit ipsum velit",
        'first_due_date' => "2018-02-07T00:00:00-03:00",
        'first_total' => 1430,
        'second_due_date' => "2018-01-31T00:00:00-03:00",
        'second_total' => 1430,
        'barcode' => "29680000101000001799600014300018038000000074",
        'checkout_url' => "https://checkout.pagos360.com/payment-request/bcd5855d-2313-11e9-b4f6-0a458c07b878",
        'barcode_url' => "https://api.pagos360.com/payment-request/barcode/bcd5855d-2313-11e9-b4f6-0a458c07b878",
        'pdf_url' => "https://api.pagos360.com/payment-request/pdf/bcd5855d-2313-11e9-b4f6-0a458c07b878",
        'request_result' => [],
    ];

    /**
     * @var array
     */
    private $collectedResult = [
        "id" => 24135,
        "type" => "collected_payment_request_result",
        "channel" => "Rapipago",
        "paid_at" => "2019-03-14T00:00:00-03:00",
        "created_at" => "2019-03-15T08:40:29-03:00",
        "available_at" => "2019-03-20T00:00:00-03:00",
        "is_available" => true,
        "amount" => 7677.81,
        "gross_fee" => 370.68,
        "net_fee" => 306.34,
        "fee_iva" => 64.33,
        "net_amount" => 7307.13,
    ];

    /**
     * @test
     */
    public function builds()
    {
        $restClient = $this->mockRestClientGet($this->mockedResponse);
        $repo = new PaymentRequestRepository($restClient);

        $paymentRequest = $repo->get(1);

        $this->assertInstanceOf(PaymentRequest::class, $paymentRequest);
    }

    /**
     * @test
     */
    public function noExternalReferenceIsNull()
    {
        $restClient = $this->mockRestClientGet($this->mockedResponse);
        $repo = new PaymentRequestRepository($restClient);

        $paymentRequest = $repo->get(1);

        $this->assertNull($paymentRequest->getExternalReference());
    }

    /**
     * @test
     */
    public function hasCreatedAt()
    {
        $restClient = $this->mockRestClientGet($this->mockedResponse);
        $repo = new PaymentRequestRepository($restClient);

        $paymentRequest = $repo->get(1);

        $this->assertInstanceOf(
            \DateTimeInterface::class,
            $paymentRequest->getCreatedAt()
        );
    }

    /**
     * @test
     */
    public function results()
    {
        $mockedResponse = $this->mockedResponse;
        $mockedResponse['request_result'][] = $this->collectedResult;
        $restClient = $this->mockRestClientGet($mockedResponse);
        $repo = new PaymentRequestRepository($restClient);

        $paymentRequest = $repo->get(1);

        $results = $paymentRequest->getResults();
        $this->assertInstanceOf(
            ArrayCollection::class,
            $results
        );
        $this->assertInstanceOf(Result::class, $results->first());
    }
}
