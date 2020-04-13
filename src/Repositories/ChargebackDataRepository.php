<?php

namespace Pagos360\Repositories;

use Pagos360\ModelFactory;
use Pagos360\Models\ChargebackData;
use Pagos360\Models\ChargebackReport;
use Pagos360\Types;

class ChargebackDataRepository extends AbstractRepository
{
    const MODEL = ChargebackData::class;
    const API_URI = 'report/chargeback';
    const EDITABLE = false;
    const FIELDS = [
        "informedDate" => [
            self::TYPE => Types::DATETIME,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => "informed_date",
        ],
        "requestId" => [
            self::TYPE => Types::INT,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => "request_id",
        ],
        "externalReference" => [
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => "external_reference",
            self::FLAG_MAYBE => true,
        ],
        "payerName" => [
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => "payer_name",
        ],
        "description" => [
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => "description",
        ],
        "channel" => [
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => "channel",
        ],
        "revertedAmount" => [
            self::TYPE => Types::FLOAT,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => "reverted_amount",
        ],
    ];

    /**
     * @param \DateTimeInterface $datetime
     * @return ChargebackReport
     */
    public function get(\DateTimeInterface $datetime): ChargebackReport
    {
        $url = sprintf('%s/%s', self::API_URI, $datetime->format('d-m-Y'));
        $fromApi = $this->restClient->get($url);

        return ModelFactory::build(self::MODEL, $fromApi);
    }
}
