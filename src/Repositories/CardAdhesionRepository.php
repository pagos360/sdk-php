<?php

namespace Pagos360\Repositories;

use Pagos360\Constants;
use Pagos360\Exceptions\CardAdhesions\CardAdhesionNotSignedException;
use Pagos360\ModelFactory;
use Pagos360\Models\CardAdhesion;
use Pagos360\Types;

class CardAdhesionRepository extends AbstractRepository
{
    const MODEL = CardAdhesion::class;
    const BLOCK_PREFIX = 'card_adhesion';
    const API_URI = 'card-adhesion';
    const FIELDS = [
        "adhesionHolderName" => [
            self::PROPERTY_PATH => "adhesion_holder_name",
            self::TYPE => Types::STRING,
            self::FLAG_REQUIRED => true,
            self::FLAG_READONLY => false,
        ],
        "email" => [
            self::TYPE => Types::STRING,
            self::FLAG_REQUIRED => true,
            self::FLAG_READONLY => false,
        ],
        "description" => [
            self::TYPE => Types::STRING,
            self::FLAG_REQUIRED => true,
            self::FLAG_READONLY => false,
        ],
        "externalReference" => [
            self::PROPERTY_PATH => "external_reference",
            self::TYPE => Types::STRING,
            self::FLAG_REQUIRED => true,
            self::FLAG_READONLY => false,
        ],
        "cardNumber" => [
            self::PROPERTY_PATH => "card_number",
            self::TYPE => Types::STRING,
            self::FLAG_REQUIRED => true,
            self::FLAG_READONLY => false,
            self::FLAG_WRITEONLY => true,
        ],
        "cardHolderName" => [
            self::PROPERTY_PATH => "card_holder_name",
            self::TYPE => Types::STRING,
            self::FLAG_REQUIRED => true,
            self::FLAG_READONLY => false,
        ],
        "metadata" => [
            self::TYPE => Types::ARRAY, // @todo review
            self::FLAG_REQUIRED => false,
            self::FLAG_READONLY => false,
        ],
        "id" => [
            self::TYPE => Types::INT,
            self::PROPERTY_PATH => "id",
            self::FLAG_READONLY => true,
        ],
        "lastFourDigits" => [
            self::PROPERTY_PATH => "last_four_digits",
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
        ],
        "card" => [
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
        ],
        "state" => [
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
        ],
        "createdAt" => [
            self::PROPERTY_PATH => "created_at",
            self::TYPE => Types::DATETIME,
            self::FLAG_READONLY => true,
        ],
        "stateComment" => [
            self::PROPERTY_PATH => "state_comment",
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
            self::FLAG_MAYBE => true,
        ],
        "canceledAt" => [
            self::PROPERTY_PATH => "canceled_at",
            self::TYPE => Types::DATETIME,
            self::FLAG_READONLY => true,
            self::FLAG_MAYBE => true,
        ],
    ];

    /**
     * @param int $id
     * @return CardAdhesion
     */
    public function get(int $id): CardAdhesion
    {
        $url = sprintf('%s/%s', self::API_URI, $id);
        $fromApi = $this->restClient->get($url);

        /** @var CardAdhesion $instantiated */
        $instantiated = ModelFactory::build(self::MODEL, $fromApi);
        return $instantiated;
    }

    /**
     * @param CardAdhesion $cardAdhesion
     * @return CardAdhesion
     */
    public function create(CardAdhesion $cardAdhesion): CardAdhesion
    {
        $serialized = $this->buildBodyToSave(
            $cardAdhesion,
            self::BLOCK_PREFIX,
            self::FIELDS
        );
        $fromApi = $this->restClient->post(self::API_URI, $serialized);

        /** @var CardAdhesion $instantiated */
        $instantiated = ModelFactory::build(self::MODEL, $fromApi);
        return $instantiated;
    }

    /**
     * @param CardAdhesion $cardAdhesion
     * @return CardAdhesion
     */
    public function cancel(CardAdhesion $cardAdhesion): CardAdhesion
    {
        $serialized = [];
        $url = sprintf('%s/%s/cancel', self::API_URI, $cardAdhesion->getId());
        $fromApi = $this->restClient->put($url, $serialized);

        /** @var CardAdhesion $instantiated */
        $instantiated = ModelFactory::build(self::MODEL, $fromApi);
        return $instantiated;
    }

    /**
     * @param CardAdhesion $cardAdhesion
     * @return bool
     */
    public function isSigned(CardAdhesion $cardAdhesion): bool
    {
        return $cardAdhesion->getState() === Constants::CARD_ADHESION_SIGNED_STATE;
    }

    /**
     * @param CardAdhesion $cardAdhesion
     * @return CardAdhesion
     * @throws CardAdhesionNotSignedException
     */
    public function assertIsSigned(
        CardAdhesion $cardAdhesion
    ): CardAdhesion {
        if (!$this->isSigned($cardAdhesion)) {
            throw new CardAdhesionNotSignedException($cardAdhesion);
        }

        return $cardAdhesion;
    }
}
