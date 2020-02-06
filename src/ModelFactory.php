<?php

namespace Pagos360;

use Doctrine\Common\Collections\ArrayCollection;
use Pagos360\Models\Account;
use Pagos360\Models\Adhesion;
use Pagos360\Models\CollectedData;
use Pagos360\Models\CollectedReport;
use Pagos360\Models\DebitRequest;
use Pagos360\Models\HolderData;
use Pagos360\Models\PaymentMetadata;
use Pagos360\Models\PaymentRequest;
use Pagos360\Models\Result;
use Pagos360\Repositories\AbstractRepository;
use Pagos360\Repositories\AccountRepository;
use Pagos360\Repositories\AdhesionRepository;
use Pagos360\Repositories\CollectedDataRepository;
use Pagos360\Repositories\CollectedReportRepository;
use Pagos360\Repositories\DebitRequestRepository;
use Pagos360\Repositories\HolderDataRepository;
use Pagos360\Repositories\PaymentMetadataRepository;
use Pagos360\Repositories\PaymentRequestRepository;
use Pagos360\Repositories\ResultRepository;

class ModelFactory
{
    /**
     * @param string $model
     * @param array  $input
     * @return Adhesion|PaymentRequest|DebitRequest|HolderData|Account|CollectedReport
     * @throws \InvalidArgumentException
     */
    public static function build(string $model, array $input)
    {
        switch ($model) {
            case Adhesion::class:
                $fields = AdhesionRepository::FIELDS;
                break;
            case DebitRequest::class:
                $fields = DebitRequestRepository::FIELDS;
                break;
            case PaymentRequest::class:
                $fields = PaymentRequestRepository::FIELDS;
                break;
            case HolderData::class:
                $fields = HolderDataRepository::FIELDS;
                break;
            case Account::class:
                $fields = AccountRepository::FIELDS;
                break;
            case Result::class:
                $fields = ResultRepository::FIELDS;
                break;
            case PaymentMetadata::class:
                $fields = PaymentMetadataRepository::FIELDS;
                break;
            case CollectedReport::class:
                $fields = CollectedReportRepository::FIELDS;
                break;
            case CollectedData::class:
                $fields = CollectedDataRepository::FIELDS;
                break;
            default:
                throw new \InvalidArgumentException("Cant build model $model");
        }

        /** @var Adhesion|PaymentRequest|DebitRequest|HolderData|Account $instance */
        $instance = new $model(self::normalizeInput($fields, $input));
        $instance->setRaw($input);

        return $instance;
    }

    /**
     * @param string $collectionOf
     * @param array  $input
     * @return ArrayCollection
     * @throws \InvalidArgumentException
     */
    public static function buildCollection(
        string $collectionOf,
        array $input
    ): ArrayCollection {
        $array = new ArrayCollection();
        switch ($collectionOf) {
            case Types::RESULTS:
                $model = Result::class;
                break;
            default:
                throw new \InvalidArgumentException('Cant build collection');
        }

        foreach ($input as $item) {
            $array[] = self::build($model, $item);
        }

        return $array;
    }

    /**
     * Returns the lookup value for a specific attribute/field from the API's
     * response, translating the name of the attribute if necessary. This serves
     * as an alias system and is mostly used for translating snake_case from the
     * API to camelCase to comply with PSR; for example, the API will have the
     * field first_due_date while internally we want to treat it as
     * firstDueDate.
     *
     * @param array  $fieldDefinition
     * @param string $key
     * @return string
     */
    public static function getLookupAttribute(
        array $fieldDefinition,
        string $key
    ): string {
        if (isset($fieldDefinition[AbstractRepository::PROPERTY_PATH])) {
            return $fieldDefinition[AbstractRepository::PROPERTY_PATH];
        }

        return $key;
    }

    /**
     * This method has a similar purpose to getLookupAttribute(), but used when
     * creating entities.
     *
     * @param array  $fieldDefinition
     * @param string $key
     * @return string
     */
    public static function getParameterAttribute(
        array $fieldDefinition,
        string $key
    ): string {
        if ($fieldDefinition[AbstractRepository::TYPE] === Types::ADHESION) {
            return 'adhesion_id';
        }

        return self::getLookupAttribute($fieldDefinition, $key);
    }

    /**
     * Normalizes the input given by the API to cast values to their proper
     * type, translates attributes fields, etc.
     *
     * @param array $fields Array with the field definitions.
     * @param array $input  An array as fetched from the API.
     * @return array
     */
    public static function normalizeInput(
        array $fields,
        array $input
    ): array {
        $normalized = [];
        foreach ($fields as $key => $fieldDefinition) {
            $lookupAttribute = self::getLookupAttribute($fieldDefinition, $key);

            if (!isset($input[$lookupAttribute])) {
                // This means the API didn't return this value.
                continue;
            }

            $castedValue = self::cast(
                $fieldDefinition,
                $input[$lookupAttribute]
            );

            $normalized[$key] = $castedValue;
        }

        return $normalized;
    }

    /**
     * @param array $fieldDefinition
     * @param mixed $value           The value to be cast.
     * @return mixed|int|string
     * @throws \InvalidArgumentException
     */
    public static function cast(array $fieldDefinition, $value)
    {
        $maybe = $fieldDefinition[AbstractRepository::FLAG_MAYBE] ?? false;
        if ($maybe && empty($value)) {
            return null;
        }

        $type = $fieldDefinition[AbstractRepository::TYPE];
        switch ($type) {
            case Types::ADHESION:
                return self::build(Adhesion::class, $value);
            case Types::HOLDER_DATA:
                return self::build(HolderData::class, $value);
            case Types::PAYMENT_METADATA:
                return self::build(PaymentMetadata::class, $value);
            case Types::COLLECTED_REPORT:
                return self::build(CollectedReport::class, $value);
            case Types::COLLECTED_DATA:
                return self::buildCollection(CollectedData::class, $value);
            case Types::RESULTS:
                return self::buildCollection(Types::RESULTS, $value);
            case Types::INT:
                return (int) $value;
            case Types::STRING:
            case Types::URL:
            case Types::EMAIL:
                return (string) $value;
            case Types::FLOAT:
                return (float) $value;
            case Types::DATE:
            case Types::DATETIME:
                return new \DateTimeImmutable($value);
            case Types::ARRAY:
            case Types::ARRAY_OF_STRINGS:
                return $value;
            case Types::BOOL:
                return (bool) $value;
            default:
                throw new \InvalidArgumentException(
                    "Unable to cast to type:" . $type
                );
        }
    }
}
