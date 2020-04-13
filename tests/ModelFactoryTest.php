<?php

namespace Tests;

use Pagos360\ModelFactory;
use Pagos360\Models\PaymentRequest;
use PHPUnit\Framework\TestCase;

class ModelFactoryTest extends TestCase
{
    /**
     * @return array
     */
    protected function mockApiResponse(): array
    {
        $json = <<<JSON
{
    "id": 269935,
    "type": "payment_request",
    "state": "pending",
    "created_at": "2019-06-06T09:49:28-03:00",
    "external_reference": "12",
    "payer_name": "Matias Pino",
    "payer_email": "mpino@pagos360.com",
    "description": "SDK test",
    "first_due_date": "2020-06-05T00:00:00-03:00",
    "first_total": 13.53,
    "barcode": "29680000093000002699440000135320157000000008",
    "checkout_url": "https://checkout.pagos360.com/payment-request/85bbba6e-8859-11e9-bbc4-0ebf3cf8eb96",
    "barcode_url": "https://api.pagos360.com/payment-request/barcode/85bbba6e-8859-11e9-bbc4-0ebf3cf8eb96",
    "pdf_url": "https://api.pagos360.com/payment-request/pdf/85bbba6e-8859-11e9-bbc4-0ebf3cf8eb96",
    "excluded_channels": [
        "non_banking"
    ]
}
JSON;

        return json_decode($json, true);
    }

    /**
     * @test
     */
    public function basic()
    {
        $mockId = 269935;
        $mockState = 'paid';
        $input = $this->mockApiResponse();
        $input['id'] = $mockId;
        $input['state'] = $mockState;

        /** @var PaymentRequest $entity */
        $entity = ModelFactory::build(PaymentRequest::class, $input);

        $this->assertInstanceOf(PaymentRequest::class, $entity);
        $this->assertSame($mockId, $entity->getId());
        $this->assertSame($mockState, $entity->getState());
    }
}
