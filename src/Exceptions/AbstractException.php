<?php

namespace Pagos360\Exceptions;

use Throwable;

abstract class AbstractException extends \Exception
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @param array          $data
     * @param Throwable|null $previous
     */
    public function __construct(
        array $data = [],
        Throwable $previous = null
    ) {
        $this->data = $data;
        parent::__construct($this->getMessage(), 0, $previous);
    }

    /**
     * @param array $extraData
     * @return AbstractException
     */
    public function appendData(array $extraData): self
    {
        $this->data = array_merge($this->data, $extraData);
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): ?array
    {
        return $this->data;
    }
}
