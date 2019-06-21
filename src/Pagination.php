<?php

namespace Pagos360;

class Pagination
{
    /**
     * @var int
     */
    private $currentPage;

    /**
     * @var int
     */
    private $itemsPerPage;

    /**
     * @var int|null
     */
    private $totalCount;

    /**
     * @param int      $page
     * @param int      $itemsPerPage
     * @param int|null $totalCount
     */
    public function __construct(
        int $page = 1,
        int $itemsPerPage = 10,
        int $totalCount = null
    ) {
        $this->currentPage = $page;
        $this->itemsPerPage = $itemsPerPage;
        $this->totalCount = $totalCount;
    }

    /**
     * @return bool
     */
    public function hasMore(): bool
    {
        if (\is_null($this->totalCount)) {
            return false; // @todo review
        }
        $resultsBefore = $this->currentPage * $this->itemsPerPage;
        return $resultsBefore < $this->totalCount;
    }

    /**
     * @return Pagination
     */
    public function advancePage(): self
    {
        $this->currentPage++;
        return $this;
    }

    /**
     * @return array
     */
    public function toQueryString(): array
    {
        return [
            'page' => $this->currentPage,
            'limit' => $this->itemsPerPage,
        ];
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    /**
     * @return int|null
     */
    public function getTotalCount(): ?int
    {
        return $this->totalCount;
    }
}
