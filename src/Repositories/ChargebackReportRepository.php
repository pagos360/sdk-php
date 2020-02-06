<?php

namespace Pagos360\Repositories;

use Pagos360\ModelFactory;
use Pagos360\Models\ChargebackReport;
use Pagos360\Types;

class ChargebackReportRepository extends AbstractRepository
{
    const MODEL = ChargebackReport::class;
    const API_URI = 'report/chargeback';
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
        "totalChargeback" => [
            self::PROPERTY_PATH => "total_chargeback",
            self::TYPE => Types::FLOAT,
            self::FLAG_READONLY => true,
        ],
        "data" => [
            self::PROPERTY_PATH => "data",
            self::TYPE => Types::CHARGEBACK_DATA,
            self::FLAG_READONLY => true,
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
