<?php

namespace Pagos360\Repositories;

use Doctrine\Common\Collections\ArrayCollection;
use Pagos360\Exceptions\MissingRequiredInputException;
use Pagos360\Filters\AbstractFilters;
use Pagos360\ModelFactory;
use Pagos360\Models\AbstractModel;
use Pagos360\Models\Adhesion;
use Pagos360\Pagination;
use Pagos360\RestClient;
use Pagos360\Types;
use Psr\Log\LoggerAwareTrait;

abstract class AbstractRepository
{
    use LoggerAwareTrait;

    const EDITABLE = false;

    const TYPE = 'type';
    const FLAG_READONLY = 'readonly';
    const FLAG_REQUIRED = 'required';
    const FLAG_EDITABLE = 'editable';
    const PROPERTY_PATH = 'propertyPath';

    /**
     * Indicates that the field may or not be present in the API's response.
     */
    const FLAG_MAYBE = 'maybe';

    /**
     * @var RestClient
     */
    protected $restClient;

    /**
     * @param RestClient $restClient
     */
    public function __construct(RestClient $restClient)
    {
        $this->restClient = $restClient;
    }

    /**
     * @param AbstractModel $model
     * @param string        $blockPrefix
     * @param array         $fields
     * @return array
     * @throws MissingRequiredInputException
     */
    public function buildBodyToSave(
        AbstractModel $model,
        string $blockPrefix,
        array $fields
    ): array {
        $serialized = [];
        foreach ($fields as $key => $field) {
            if ($this->isReadonly($field)) {
                continue;
            }

            if ($model->has($key)) {
                $value = $model->get($key);
                $lookupKey = ModelFactory::getParameterAttribute($field, $key);

                $castedValue = $this->transformField(
                    $field[AbstractRepository::TYPE],
                    $value
                );
                $serialized[$lookupKey] = $castedValue;
            } else {
                if ($this->isRequired($field)) {
                    throw new MissingRequiredInputException([
                        'model' => $model,
                        'field' => $key,
                        'type' => $field[AbstractRepository::TYPE],
                    ]);
                }
            }
        }

        return [$blockPrefix => $serialized];
    }

    /**
     * @param AbstractFilters|null $filters
     * @return array
     */
    protected function parseFilters(?AbstractFilters $filters): array
    {
        if (empty($filters)) {
            return [];
        }

        return $filters->toQueryParams();
    }

    /**
     * @param int             $page
     * @param int             $itemsPerPage
     * @param AbstractFilters $filters
     * @return array
     */
    protected function buildPagedQueryString(
        int $page,
        int $itemsPerPage,
        ?AbstractFilters $filters
    ): array {
        $pagination = new Pagination($page, $itemsPerPage);
        $parsedFilters = $this->parseFilters($filters);

        return array_merge(
            $parsedFilters,
            $pagination->toQueryString()
        );
    }

    /**
     * @param string $modelClass
     * @param array  $input
     * @return ArrayCollection|AbstractModel[]
     */
    protected function parseDatafromPaginatedResponse(
        string $modelClass,
        array $input
    ): ArrayCollection {
        $data = new ArrayCollection();
        foreach ($input['data'] as $entity) {
            $data[] = ModelFactory::build($modelClass, $entity);
        }

        return $data;
    }

    /**
     * @param array $response
     * @return Pagination
     */
    protected function getPaginationFromPaginatedResponse(
        array $response
    ): Pagination {
        return new Pagination(
            $response['current_page'],
            $response['items_per_page'],
            $response['total_count']
        );
    }

    /**
     * Converts an internal type into the parameter expected by the api. For
     * example, it trnasforms a DateTime object into a formated string, and an
     * adhesion instance into its id.
     *
     * @param string $type
     * @param mixed  $value
     * @return \DateTimeImmutable|string
     * @todo review if this should be moved to ModelFactory. Seeing I had to
     *       import Types, the answer is most likely yes.
     */
    protected function transformField(string $type, $value)
    {
        switch ($type) {
            case Types::ADHESION:
                /** @var Adhesion $value */
                return $value->getId();
            case Types::DATETIME:
                /** @var \DateTimeImmutable $value */
                return $value->format('d-m-Y H:i:s');
            case Types::DATE:
                /** @var \DateTimeImmutable $value */
                return $value->format('d-m-Y');
            default:
                return $value;
        }
    }

    /**
     * @param array $fieldDefinition
     * @return bool
     */
    protected function isReadonly(array $fieldDefinition): bool
    {
        return $fieldDefinition[self::FLAG_READONLY] ?? false;
    }

    /**
     * @param array $fieldDefinition
     * @return bool
     */
    protected function isRequired(array $fieldDefinition): bool
    {
        return $fieldDefinition[self::FLAG_REQUIRED] ?? false;
    }
}
