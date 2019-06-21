<?php

namespace Tests\Repositories;

use Pagos360\Models\AbstractModel;
use Pagos360\Repositories\AbstractRepository;
use Pagos360\RestClient;
use Pagos360\Types;

class AbstractRepositoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @return ConcreteRepository
     */
    protected function getRepository()
    {
        return new ConcreteRepository(
            $this->createMock(RestClient::class)
        );
    }

    /**
     * @test
     */
    public function addsPrefixBlock()
    {
        $fields = [];
        $model = $this->createMock(AbstractModel::class);
        $blockPrefix = 'prefix_block';

        $body = $this->getRepository()->buildBodyToSave(
            $model,
            $blockPrefix,
            $fields
        );

        $this->assertIsArray($body);
        self::assertCount(1, $body);
        $this->assertArrayHasKey($blockPrefix, $body);
    }

    /**
     * @test
     */
    public function ignoresReadOnly()
    {
        $fields = [
            'id' => [
                AbstractRepository::FLAG_REQUIRED => true,
                AbstractRepository::TYPE => Types::INT,
            ],
            'createdAt' => [
                AbstractRepository::FLAG_READONLY => true,
                AbstractRepository::TYPE => Types::INT,
            ],
        ];
        $model = $this->createMock(AbstractModel::class);
        $model->method('has')->willReturn(true);
        $blockPrefix = 'irrelevant';
        $repository = $this->getRepository();

        $body = $repository->buildBodyToSave($model, $blockPrefix, $fields);

        $this->assertIsArray($body);
        $this->assertCount(1, $body['irrelevant']);
    }

    /**
     * @test
     */
    public function throwsOnMissingRequiredField()
    {
        $fields = [
            'id' => [
                AbstractRepository::FLAG_REQUIRED => true,
                AbstractRepository::TYPE => Types::INT,
            ]
        ];
        $model = $this->createMock(AbstractModel::class);
        $model->method('has')->willReturn(false);
        $blockPrefix = 'irrelevant';

        $this->expectException(\Throwable::class);
        $this->getRepository()->buildBodyToSave($model, $blockPrefix, $fields);
    }
}
