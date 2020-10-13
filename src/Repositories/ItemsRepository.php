<?php

namespace Pagos360\Repositories;

use Pagos360\Types;

class ItemsRepository extends AbstractRepository
{
    const EDITABLE = false;
    const FIELDS = [
        'quantity' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::INT,
            self::PROPERTY_PATH => 'quantity',
        ],
        'description' => [
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => 'description',
        ],
        'amount' => [
            self::TYPE => Types::FLOAT,
            self::FLAG_READONLY => true,
        ],
    ];
}
