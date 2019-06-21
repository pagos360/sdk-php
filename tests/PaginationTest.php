<?php

namespace Tests;

use Pagos360\Pagination;
use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase
{
    /**
     * @test
     */
    public function getters()
    {
        $currentPage = rand(1,1000);
        $itemsPerPage = rand(1,1000);
        $totalCount = rand(1,1000);

        $pagination = new Pagination($currentPage, $itemsPerPage, $totalCount);

        $this->assertIsInt($pagination->getCurrentPage());
        $this->assertSame($currentPage, $pagination->getCurrentPage());
        $this->assertIsInt($pagination->getItemsPerPage());
        $this->assertSame($itemsPerPage, $pagination->getItemsPerPage());
        $this->assertIsInt($pagination->getTotalCount());
        $this->assertSame($totalCount, $pagination->getTotalCount());
    }

    /**
     * @test
     */
    public function hasMore()
    {
        $currentPage = 1;
        $itemsPerPage = 10;
        $totalCount = 100;

        $pagination = new Pagination($currentPage, $itemsPerPage, $totalCount);
        $hasMore = $pagination->hasMore();

        $this->assertIsBool($hasMore);
        $this->assertTrue($hasMore);
    }

    /**
     * @test
     */
    public function doenstHaveMoreOnSinglePage()
    {
        $currentPage = 1;
        $itemsPerPage = 10;
        $totalCount = 3;

        $pagination = new Pagination($currentPage, $itemsPerPage, $totalCount);
        $hasMore = $pagination->hasMore();

        $this->assertIsBool($hasMore);
        $this->assertFalse($hasMore);
    }

    /**
     * @test
     */
    public function doesntHaveMoreOnPage()
    {
        $currentPage = 2;
        $itemsPerPage = 5;
        $totalCount = 10;

        $pagination = new Pagination($currentPage, $itemsPerPage, $totalCount);
        $hasMore = $pagination->hasMore();

        $this->assertIsBool($hasMore);
        $this->assertFalse($hasMore);
    }

    /**
     * @test
     */
    public function hasMoreByOne()
    {
        $currentPage = 2;
        $itemsPerPage = 5;
        $totalCount = 11;

        $pagination = new Pagination($currentPage, $itemsPerPage, $totalCount);
        $hasMore = $pagination->hasMore();

        $this->assertIsBool($hasMore);
        $this->assertTrue($hasMore);
    }

    /**
     * @test
     */
    public function regressionPastPage()
    {
        $currentPage = 30;
        $itemsPerPage = 20;
        $totalCount = 45;

        $pagination = new Pagination($currentPage, $itemsPerPage, $totalCount);
        $hasMore = $pagination->hasMore();

        $this->assertIsBool($hasMore);
        $this->assertFalse($hasMore);
    }
}
