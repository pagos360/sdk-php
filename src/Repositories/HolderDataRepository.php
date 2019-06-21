<?php

namespace Pagos360\Repositories;

use Pagos360\Models\PaymentRequest;
use Pagos360\Types;

class HolderDataRepository extends AbstractRepository
{
    const MODEL = PaymentRequest::class;

    const EDITABLE = false;
    const FIELDS = [
        'name' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::STRING,
            self::PROPERTY_PATH => 'holder_name',
        ],
        'email' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::STRING,
            self::PROPERTY_PATH => 'holder_email',
        ],
    ];
}
