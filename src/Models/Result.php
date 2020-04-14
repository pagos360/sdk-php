<?php

namespace Pagos360\Models;

class Result extends AbstractModel
{
    /**
     * ID de Resultado de la Solicitud de Pago.
     *
     * @var int
     */
    protected $id;

    /**
     * Tipo de Resultado. Valores posibles:  collected_payment_request_result,
     * rejected_payment_request_result y chargeback_payment_request_result.
     *
     * @var string
     */
    protected $type;

    /**
     * Canal de pago utilizado.
     *
     * @var string|null
     */
    protected $channel;

    /**
     * Fecha y hora en la que el saldo de la transacción queda disponible.
     *
     * @var \DateTimeImmutable|null
     */
    protected $availableAt;

    /**
     * Indica si la fecha de el importe se encuentra o no como Saldo Disponible.
     *
     * @var bool|null
     */
    protected $isAvailable;

    /**
     * Importe pagado relativo a las fechas de vencimiento de la Solicitud.
     *
     * @var float|null
     */
    protected $amount;

    /**
     * Importe total correspondiente a la tarifa de procesamiento. Es devengado
     * del importe pagado (atributo amount).
     *
     * @var float|null
     */
    protected $grossFee;

    /**
     * Importe neto (sin IVA) correspondiente a la tarifa de procesamiento.
     *
     * @var float|null
     */
    protected $netFee;

    /**
     * Importe reflejado como Saldo en la cuenta (amount - gross_fee).
     *
     * @var float|null
     */
    protected $netAmount;

    /**
     * IVA correspondiente a la tarifa de procesamiento.
     *
     * @var float|null
     */
    protected $feeIva;

    /**
     * Información adicional sobre los pagos con Tarjeta de Crédito y Debito.
     *
     * @var PaymentMetadata|null
     */
    protected $paymentMetadata;

    /**
     * Fecha y hora de creación.
     *
     * @var \DateTimeImmutable|null
     */
    protected $createdAt;

    /**
     * Fecha en la que el Pagador realizó el pago.
     *
     * @var \DateTimeImmutable|null
     */
    protected $paidAt;

    /**
     * En caso que sea una Solicitud de Debito, este campo indica la fecha y
     * hora en la que fue rechazada.
     *
     * @var \DateTimeImmutable|null
     */
    protected $rejectedAt;

    /**
     * En caso que sea una Solicitud de Debito, este campo indica el motivo de
     * rechazo o cancelación.
     *
     * @var string|null
     */
    protected $stateComment;

    /**
     * Fecha y hora en la que el Pago/Débito fue Revertido.
     *
     * @var \DateTimeImmutable|null
     */
    protected $revertedAt;

    /**
     * @return int
     */
    public function getId(): int
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
     * @return string|null
     */
    public function getChannel(): ?string
    {
        return $this->channel;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getAvailableAt(): ?\DateTimeInterface
    {
        return $this->availableAt;
    }

    /**
     * @return bool|null
     */
    public function getIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @return float|null
     */
    public function getGrossFee(): ?float
    {
        return $this->grossFee;
    }

    /**
     * @return float|null
     */
    public function getNetFee(): ?float
    {
        return $this->netFee;
    }

    /**
     * @return float|null
     */
    public function getNetAmount(): ?float
    {
        return $this->netAmount;
    }

    /**
     * @return float|null
     */
    public function getFeeIva(): ?float
    {
        return $this->feeIva;
    }

    /**
     * @return PaymentMetadata|null
     */
    public function getPaymentMetadata(): ?PaymentMetadata
    {
        return $this->paymentMetadata;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getPaidAt(): ?\DateTimeImmutable
    {
        return $this->paidAt;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getRejectedAt(): ?\DateTimeImmutable
    {
        return $this->rejectedAt;
    }

    /**
     * @return string|null
     */
    public function getStateComment(): ?string
    {
        return $this->stateComment;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getRevertedAt(): ?\DateTimeImmutable
    {
        return $this->revertedAt;
    }
}
