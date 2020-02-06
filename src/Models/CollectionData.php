<?php

namespace Pagos360\Models;

class CollectionData extends AbstractModel
{
    /**
     * Fecha en la que se informo el Cobro.
     *
     * @var \DateTimeImmutable
     */
    protected $informedDate;

    /**
     * ID de la Solicitud de Pago.
     *
     * @var int
     */
    protected $requestId;

    /**
     * Este atributo es utilizado como referencia para identificar la Solicitud
     * de Pago y sincronizar con tus sistemas de backend el origen de la
     * operación. Algunos valores comunmente utilizados son: ID de Cliente, DNI,
     * CUIT, ID de venta o Nro. de Factura entre otros.
     *
     * @var string
     */
    protected $externalReference;

    /**
     * Nombre del pagador de la Solicitud de Pago.
     *
     * @var string
     */
    protected $payerName;

    /**
     * Descripción o concepto de la Solicitud de Pago.
     *
     * @var string
     */
    protected $description;

    /**
     * Fecha en la que se informo el Cobro.
     *
     * @var \DateTimeImmutable
     */
    protected $paymentDate;

    /**
     * Canal de pago utilizado.
     *
     * @var string
     */
    protected $channel;

    /**
     * Importe Pagado.
     *
     * @var float
     */
    protected $amountPaid;

    /**
     * Comisión Neta.
     *
     * @var float
     */
    protected $netFee;

    /**
     * Importe Reversado.
     *
     * @var float
     */
    protected $ivaFee;

    /**
     * Importe Neto.
     *
     * @var float
     */
    protected $netAmount;

    /**
     * Fecha y hora en la que el saldo de la transacción queda disponible.
     *
     * @var \DateTimeImmutable
     */
    protected $availableAt;

    /**
     * @return \DateTimeImmutable
     */
    public function getInformedDate(): \DateTimeImmutable
    {
        return $this->informedDate;
    }

    /**
     * @return int
     */
    public function getRequestId(): int
    {
        return $this->requestId;
    }

    /**
     * @return string
     */
    public function getExternalReference(): string
    {
        return $this->externalReference;
    }

    /**
     * @return string
     */
    public function getPayerName(): string
    {
        return $this->payerName;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getPaymentDate(): \DateTimeImmutable
    {
        return $this->paymentDate;
    }

    /**
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * @return float
     */
    public function getAmountPaid(): float
    {
        return $this->amountPaid;
    }

    /**
     * @return float
     */
    public function getNetFee(): float
    {
        return $this->netFee;
    }

    /**
     * @return float
     */
    public function getIvaFee(): float
    {
        return $this->ivaFee;
    }

    /**
     * @return float
     */
    public function getNetAmount(): float
    {
        return $this->netAmount;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getAvailableAt(): \DateTimeImmutable
    {
        return $this->availableAt;
    }
}
