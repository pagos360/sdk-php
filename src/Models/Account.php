<?php

namespace Pagos360\Models;

class Account extends AbstractModel
{
    /**
     * Identificador de la Cuenta.
     *
     * @var string
     */
    protected $id;

    /**
     * Saldo disponible.
     *
     * @var float
     */
    protected $availableBalance;

    /**
     * Saldo pendiente.
     *
     * @var float
     */
    protected $unavailableBalance;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getAvailableBalance(): float
    {
        return $this->availableBalance;
    }

    /**
     * @return float
     */
    public function getUnavailableBalance(): float
    {
        return $this->unavailableBalance;
    }
}
