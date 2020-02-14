<?php

namespace Pagos360\Repositories;

use Pagos360\ModelFactory;
use Pagos360\Models\SettlementReport;
use Pagos360\Types;

class SettlementReportRepository extends AbstractRepository
{
    const MODEL = SettlementReport::class;
    const API_URI = 'report/settlement';
    const EDITABLE = false;
    const FIELDS = [
        "accountId" => [
            self::PROPERTY_PATH => "account_id",
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
        ],
        "reportDate" => [
            self::PROPERTY_PATH => "report_date",
            self::TYPE => Types::DATETIME,
            self::FLAG_READONLY => true,
        ],
        "totalCredits" => [
            self::PROPERTY_PATH => "total_credits",
            self::TYPE => Types::INT,
            self::FLAG_READONLY => true,
        ],
        "creditAmount" => [
            self::PROPERTY_PATH => "credit_amount",
            self::TYPE => Types::FLOAT,
            self::FLAG_READONLY => true,
        ],
        "totalDebits" => [
            self::PROPERTY_PATH => "total_debits",
            self::TYPE => Types::INT,
            self::FLAG_READONLY => true,
        ],
        "debitAmount" => [
            self::PROPERTY_PATH => "debit_amount",
            self::TYPE => Types::FLOAT,
            self::FLAG_READONLY => true,
        ],
        "settlementAmount" => [
            self::PROPERTY_PATH => "settlement_amount",
            self::TYPE => Types::FLOAT,
            self::FLAG_READONLY => true,
        ],
        "data" => [
            self::TYPE => Types::SETTLEMENT_DATA,
            self::FLAG_READONLY => true,
        ],
    ];


    /**
     * @param \DateTimeInterface $datetime
     * @return SettlementReport
     */
    public function get(\DateTimeInterface $datetime): SettlementReport
    {
        $url = sprintf('%s/%s', self::API_URI, $datetime->format('d-m-Y'));
        $fromApi = $this->restClient->get($url);

        return ModelFactory::build(self::MODEL, $fromApi);
    }
}
