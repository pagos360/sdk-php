<?php

namespace Pagos360\Models;

class TransferTo extends AbstractModel
{
    /**
     * @var string
     */
    protected $accountId;

    /**
     * Importe del producto o servicio. Formato: 00000000.00
     * (hasta 8 enteros y 2 decimales, utilizando punto “.”
     * como separador decimal).
     *
     * @var float
     */
    protected $amount;

    /**
     * Este atributo se puede utilizar como referencia para identificar la
     * Transferencia y sincronizar con tus sistemas de backend el origen de
     * la operación. Algunos valores comunmente utilizados son: ID de Cliente,
     * DNI, CUIT, ID de venta o Número de Factura, entre otros.
     *
     * @var string|null
     */
    protected $externalReference;

    /**
     * Descripción o concepto de la Solicitud de Pago.
     *
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected $refundable;

    /**
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->accountId;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string|null
     */
    public function getExternalReference(): ?string
    {
        return $this->externalReference;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return bool|null
     */
    public function getRefundable(): ?bool
    {
        return $this->refundable;
    }
}
