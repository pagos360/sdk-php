<?php

namespace Pagos360\Repositories;

use Pagos360\ModelFactory;
use Pagos360\Models\Adhesion;
use Pagos360\Types;

class AdhesionRepository extends AbstractRepository
{
    const MODEL = Adhesion::class;
    const BLOCK_PREFIX = 'adhesion';
    const API_URI = 'adhesion';

    const EDITABLE = false;
    const FIELDS = [
        "id" => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::INT,
            self::PROPERTY_PATH => 'id',
        ],
        "state" => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::STRING,
            self::PROPERTY_PATH => 'state',
        ],
        "createdAt" => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::DATETIME,
            self::PROPERTY_PATH => 'created_at',
        ],
        "adhesionHolderName" => [
            self::FLAG_REQUIRED => true,
            self::TYPE => Types::STRING,
            self::PROPERTY_PATH => 'adhesion_holder_name',
        ],
        "externalReference" => [
            self::FLAG_REQUIRED => true,
            self::TYPE => Types::STRING,
            self::PROPERTY_PATH => 'external_reference',
        ],
        "cbuNumber" => [
            self::FLAG_REQUIRED => true,
            self::TYPE => Types::STRING,
            self::PROPERTY_PATH => 'cbu_number',
        ],
        "cbuHolderIdNumber" => [
            self::FLAG_REQUIRED => true,
            self::TYPE => Types::INT,
            self::PROPERTY_PATH => 'cbu_holder_id_number',
        ],
        "cbuHolderName" => [
            self::FLAG_REQUIRED => true,
            self::TYPE => Types::STRING,
            self::PROPERTY_PATH => 'cbu_holder_name',
        ],
        "email" => [
            self::FLAG_REQUIRED => true,
            self::TYPE => Types::EMAIL,
            self::PROPERTY_PATH => 'email',
        ],
        "bank" => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::STRING,
            self::PROPERTY_PATH => 'bank',
        ],
        "description" => [
            self::FLAG_REQUIRED => true,
            self::TYPE => Types::STRING,
            self::PROPERTY_PATH => 'description',
        ],
        "shortDescription" => [
            self::FLAG_REQUIRED => true,
            self::TYPE => Types::STRING,
            self::PROPERTY_PATH => 'short_description',
        ],
        "stateComment" => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::STRING,
            self::PROPERTY_PATH => 'state_comment',
            self::FLAG_MAYBE => true,
        ],
        'metadata' => [
            self::TYPE => Types::ARRAY, // @todo review
            self::FLAG_MAYBE => true,
        ],
    ];

    /**
     * @param int $id
     * @return Adhesion
     */
    public function get(int $id): Adhesion
    {
        $url = sprintf('%s/%s', self::API_URI, $id);
        $fromApi = $this->restClient->get($url);

        return ModelFactory::build(self::MODEL, $fromApi);
    }

    /**
     * @param Adhesion $adhesion
     * @return Adhesion
     */
    public function create(Adhesion $adhesion): Adhesion
    {
        $serialized = $this->buildBodyToSave(
            $adhesion,
            self::BLOCK_PREFIX,
            self::FIELDS
        );

        $fromApi = $this->restClient->post(self::API_URI, $serialized);

        return ModelFactory::build(self::MODEL, $fromApi);
    }
}
