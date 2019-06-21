<?php

namespace Pagos360\Models;

class AbstractModel
{
    /**
     * @var mixed
     */
    public $raw;

    /**
     * @param array $input
     */
    public function __construct(array $input = [])
    {
        foreach ($input as $key => $value) {
            /** @noinspection PhpVariableVariableInspection */
            $this->$key = $value;
        }
    }

    /**
     * @param array $raw
     * @return AbstractModel
     */
    public function setRaw(array $raw): self
    {
        $this->raw = $raw;
        return $this;
    }

    /**
     * @param string $field
     * @return bool
     */
    public function has(string $field): bool
    {
        /** @noinspection PhpVariableVariableInspection */
        return isset($this->$field);
    }

    /**
     * @param string $field
     * @return mixed
     */
    public function get(string $field)
    {
        /** @noinspection PhpVariableVariableInspection */
        return $this->$field;
    }
}
