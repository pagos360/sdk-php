<?php

namespace Pagos360\Filters;

use Pagos360\Types;

class DebitRequestFilters extends AbstractFilters
{
    const EXTERNAL_REFERENCE = 'external_reference';
    const STATE = 'state';
    const CREATED_AT_LTE = 'created_at_lte';
    const CREATED_AT_GTE = 'created_at_gte';
    const FIRST_DUE_DATE_LTE = 'first_due_date_lte';
    const FIRST_DUE_DATE_GTE = 'first_due_date_gte';
    const FIRST_TOTAL_LTE = 'first_total_lte';
    const FIRST_TOTAL_GTE = 'first_total_gte';
    const SECOND_DUE_DATE_LTE = 'second_due_date_lte';
    const SECOND_DUE_DATE_GTE = 'second_due_date_gte';
    const SECOND_TOTAL_LTE = 'second_total_lte';
    const SECOND_TOTAL_GTE = 'second_total_gte';
    const ADHESION_HOLDER_NAME = 'adhesion_holder_name';

    /**
     * @param string $filter
     * @return string
     */
    protected function getFilterType(string $filter): string
    {
        switch ($filter) {
            case self::CREATED_AT_LTE:
            case self::CREATED_AT_GTE:
            case self::FIRST_DUE_DATE_LTE:
            case self::FIRST_DUE_DATE_GTE:
            case self::SECOND_DUE_DATE_LTE:
            case self::SECOND_DUE_DATE_GTE:
                return Types::DATE;
            case self::FIRST_TOTAL_LTE:
            case self::FIRST_TOTAL_GTE:
            case self::SECOND_TOTAL_LTE:
            case self::SECOND_TOTAL_GTE:
                return Types::FLOAT;
            case self::EXTERNAL_REFERENCE:
            case self::STATE:
            case self::ADHESION_HOLDER_NAME:
            default:
                return Types::STRING;
        }
    }
}
