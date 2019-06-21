<?php

namespace Pagos360;

use Doctrine\Common\Collections\ArrayCollection;
use Pagos360\Models\Adhesion;
use Pagos360\Models\DebitRequest;
use Pagos360\Models\PaymentRequest;

class PaginatedResponse
{
    /**
     * @var Pagination
     */
    private $pagination;

    /**
     * @var array|ArrayCollection|PaymentRequest[]|Adhesion[]|DebitRequest[]
     */
    private $data;

    /**
     * @param Pagination      $pagination
     * @param ArrayCollection $data
     */
    public function __construct(
        Pagination $pagination,
        ArrayCollection $data
    ) {
        $this->pagination = $pagination;
        $this->data = $data;
    }

    /**
     * @return Pagination
     */
    public function getPagination(): Pagination
    {
        return $this->pagination;
    }

    /**
     * @return array|ArrayCollection|PaymentRequest[]|Adhesion[]|DebitRequest[]
     */
    public function getData()
    {
        return $this->data;
    }
}
