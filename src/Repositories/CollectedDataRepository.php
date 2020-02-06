<?php

namespace Pagos360\Repositories;

use Pagos360\Models\CollectedData;
use Pagos360\Types;

class CollectedDataRepository extends AbstractRepository
{
    const MODEL = CollectedData::class;
    const EDITABLE = false;
    const FIELDS = [
        "informedDate" => [
            self::PROPERTY_PATH => "informed_date",
            self::TYPE => Types::DATETIME,
            self::FLAG_READONLY => true,
        ],
        "requestId" => [
            self::PROPERTY_PATH => "request_id",
            self::TYPE => Types::INT,
            self::FLAG_READONLY => true,
        ],
        "externalReference" => [
            self::PROPERTY_PATH => "external_reference",
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
        ],
        "payerName" => [
            self::PROPERTY_PATH => "payer_name",
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
        ],
        "description" => [
            self::PROPERTY_PATH => "description",
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
        ],
        "paymentDate" => [
            self::PROPERTY_PATH => "payment_date",
            self::TYPE => Types::DATETIME,
            self::FLAG_READONLY => true,
        ],
        "channel" => [
            self::PROPERTY_PATH => "channel",
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
        ],
        "amountPaid" => [
            self::PROPERTY_PATH => "amount_paid",
            self::TYPE => Types::FLOAT,
            self::FLAG_READONLY => true,
        ],
        "netFee" => [
            self::PROPERTY_PATH => "net_fee",
            self::TYPE => Types::FLOAT,
            self::FLAG_READONLY => true,
        ],
        "ivaFee" => [
            self::PROPERTY_PATH => "iva_fee",
            self::TYPE => Types::FLOAT,
            self::FLAG_READONLY => true,
        ],
        "netAmount" => [
            self::PROPERTY_PATH => "net_amount",
            self::TYPE => Types::FLOAT,
            self::FLAG_READONLY => true,
        ],
        "availableAt" => [
            self::PROPERTY_PATH => "available_at",
            self::TYPE => Types::DATETIME,
            self::FLAG_READONLY => true,
        ],
    ];
}
