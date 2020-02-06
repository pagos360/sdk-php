<?php

namespace Pagos360\Repositories;

use Pagos360\Models\ChargebackData;
use Pagos360\Types;

class ChargebackDataRepository extends AbstractRepository
{
    const MODEL = ChargebackData::class;
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
}
