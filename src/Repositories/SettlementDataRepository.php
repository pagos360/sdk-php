<?php

namespace Pagos360\Repositories;

use Pagos360\Models\SettlementData;
use Pagos360\Types;

class SettlementDataRepository extends AbstractRepository
{
    const MODEL = SettlementData::class;
    const API_URI = 'report/settlement';
    const EDITABLE = false;
    const FIELDS = [
        "requestId" => [
            self::PROPERTY_PATH => "request_id",
            self::FLAG_READONLY => true,
            self::TYPE => Types::INT,
        ],
        "externalReference" => [
            self::PROPERTY_PATH => "external_reference",
            self::FLAG_READONLY => true,
            self::TYPE => Types::STRING,
            self::FLAG_MAYBE => true,
        ],
        "credit" => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::FLOAT,
        ],
        "debit" => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::FLOAT,
        ],
    ];
}
