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
            self::PROPERTY_PATH => "requestId",
            self::FLAG_READONLY => true,
            self::TYPE => Types::INT,
        ],
        "externalReference" => [
            self::PROPERTY_PATH => "externalReference",
            self::FLAG_READONLY => true,
            self::TYPE => Types::STRING,
        ],
        "credit" => [
            self::PROPERTY_PATH => "credit",
            self::FLAG_READONLY => true,
            self::TYPE => Types::FLOAT,
        ],
        "debit" => [
            self::PROPERTY_PATH => "debit",
            self::FLAG_READONLY => true,
            self::TYPE => Types::FLOAT,
        ],
    ];
}
