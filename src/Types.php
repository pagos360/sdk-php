<?php

namespace Pagos360;

class Types
{
    const INT = 'int';
    const STRING = 'string';
    const FLOAT = 'float';
    const ARRAY = 'array';
    const DATE = 'date';
    const DATETIME = 'datetime';
    const URL = 'url';
    const EMAIL = 'email';
    const BOOL = 'bool';
    const ARRAY_OF_STRINGS = 'string[]';

    const ADHESION = 'adhesion';
    const HOLDER_DATA = 'holderData';
    const RESULTS = 'results';
    const COLLECTION_REPORT = 'collectionReport';
    const COLLECTION_DATA = 'collectionData';
    const SETTLEMENT_REPORT = 'settlementReport';
    const SETTLEMENT_DATA = 'settlementData';
    const CHARGEBACK_REPORT = 'chargebackReport';
    const CHARGEBACK_DATA = 'chargebackData';
    const PAYMENT_METADATA = 'paymentMetadata';
    const CARD_ADHESION = 'cardAdhesion';
}
