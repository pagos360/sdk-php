<?php

namespace Pagos360\Models;

class ChargebackData extends AbstractModel
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
     * de Pago y sincronizar con tus sistemas de backend el origen de la operación.
     * Algunos valores comunmente utilizados son: ID de Cliente, DNI, CUIT,
     * ID de venta o Nro. de Factura entre otros.
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
     * Canal de pago utilizado.
     *
     * @var string
     */
    protected $channel;

    /**
     * Importe Revertido.
     *
     * @var float
     */
    protected $revertedAmount;

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
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * @return float
     */
    public function getRevertedAmount(): float
    {
        return $this->revertedAmount;
    }
}
