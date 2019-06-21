<?php

namespace Pagos360\Filters;

use Pagos360\Types;

class AdhesionFilters extends AbstractFilters
{
    const STATE = 'state';
    const CREATED_AT_LTE = 'created_at_lte';
    const CREATED_AT_GTE = 'created_at_gte';
    const CBU_NUMBER = 'cbu_number';
    const EXTERNAL_REFERENCE = 'external_reference';
    const ADHESION_HOLDER_NAME = 'adhesion_holder_name';
    const DESCRIPTION = 'description';
    const SHORT_DESCRIPTION = 'short_description';
    const CBU_HOLDER_ID_NUMBER = 'cbu_holder_id_number';
    const CBU_HOLDER_NAME = 'cbu_holder_name';

    /**
     * @param string $filter
     * @return string
     */
    protected function getFilterType(string $filter): string
    {
        switch ($filter) {
            case self::CREATED_AT_LTE:
            case self::CREATED_AT_GTE:
                return Types::DATE;
            case self::CBU_HOLDER_ID_NUMBER:
                return Types::INT;
            case self::STATE:
            case self::CBU_NUMBER:
            case self::EXTERNAL_REFERENCE:
            case self::ADHESION_HOLDER_NAME:
            case self::DESCRIPTION:
            case self::SHORT_DESCRIPTION:
            case self::CBU_HOLDER_NAME:
            default:
                return Types::STRING;
        }
    }
}
