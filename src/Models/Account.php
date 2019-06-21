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
     * Modalidad de la Cuenta. Valores posibles current_account (Cuenta
     * Corriente) y consolidated_account (Cuenta Consolidada).
     *
     * @var string
     */
    protected $type;

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
     * Tipos de Medios de Pago habilitados para la cuenta. Valores posibles:
     * banking, credit_card, debit_card y non_banking.
     *
     * @var string[]
     */
    protected $availableChannelTypes;


    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
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

    /**
     * @return string[]
     */
    public function getAvailableChannelTypes(): array
    {
        return $this->availableChannelTypes;
    }
}
