<?php

namespace Pagos360\Repositories;

use Pagos360\ModelFactory;
use Pagos360\Models\CollectionReport;
use Pagos360\Types;

class CollectionReportRepository extends AbstractRepository
{
    const MODEL = CollectionReport::class;
    const API_URI = 'report/collection';
    const EDITABLE = false;
    const FIELDS = [
        "accountId" => [
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => 'account_id',
        ],
        "reportDate" => [
            self::TYPE => Types::DATETIME,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => 'report_date',
        ],
        "totalCollected" => [
            self::TYPE => Types::FLOAT,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => 'total_collected',
        ],
        "totalGrossFee" => [
            self::TYPE => Types::FLOAT,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => 'total_gross_fee',
        ],
        "totalNetAmount" => [
            self::TYPE => Types::FLOAT,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => 'total_net_amount',
        ],
        "data" => [
            self::TYPE => Types::COLLECTION_DATA,
            self::FLAG_READONLY => true,
        ],
    ];


    /**
     * @param \DateTimeInterface $datetime
     * @return CollectionReport
     */
    public function get(\DateTimeInterface $datetime): CollectionReport
    {
        $url = sprintf('%s/%s', self::API_URI, $datetime->format('d-m-Y'));
        $fromApi = $this->restClient->get($url);

        return ModelFactory::build(self::MODEL, $fromApi);
    }
}
