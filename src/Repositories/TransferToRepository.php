<?php

namespace Pagos360\Repositories;

use Pagos360\Types;

class TransferToRepository extends AbstractRepository
{
    const EDITABLE = false;
    const FIELDS = [
        'accountId' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::STRING,
            self::PROPERTY_PATH => 'account_id',
        ],
        'amount' => [
            self::TYPE => Types::FLOAT,
            self::FLAG_READONLY => true,
        ],
        'externalReference' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::STRING,
            self::PROPERTY_PATH => 'external_reference',
        ],
        'description' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::STRING,
            self::PROPERTY_PATH => 'description',
        ],
    ];
}
