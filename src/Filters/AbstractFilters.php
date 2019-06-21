<?php

namespace Pagos360\Filters;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Pagos360\Types;

abstract class AbstractFilters implements Countable, IteratorAggregate, ArrayAccess
{
    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @param array $filters
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->filters;
    }

    /**
     * @return array
     */
    public function toQueryParams(): array
    {
        $out = [];
        foreach ($this->filters as $filter => $value) {
            $type = $this->getFilterType($filter);
            switch ($type) {
                case Types::DATE:
                case Types::DATETIME:
                    $out[$filter] = $value->format('d-m-Y');
                    break;
                default:
                    $out[$filter] = (string) $value;
            }
        }

        return $out;
    }

    /**
     * @param string $filter
     * @return string
     */
    abstract protected function getFilterType(string $filter): string;

    /**
     * Implementation of IteratorAggregate interface.
     *
     * @return array|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->filters);
    }

    /**
     * Implementation of ArrayAccess interface.
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->filters[$offset]);
    }

    /**
     * Implementation of ArrayAccess interface.
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->filters[$offset];
    }

    /**
     * Implementation of ArrayAccess interface.
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->filters[$offset] = $value;
    }

    /**
     * Implementation of ArrayAccess interface.
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->filters[$offset]);
    }

    /**
     * Implementation of Countable interface.
     *
     * @return int
     */
    public function count()
    {
        return count($this->filters);
    }
}
