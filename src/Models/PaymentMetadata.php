<?php

namespace Pagos360\Models;

class PaymentMetadata extends AbstractModel
{
    /**
     * Nombre del pagador de la Solicitud de Pago.
     *
     * @var string
     */
    protected $holderName;

    /**
     * Email del pagador de la Solicitud de Pago.
     *
     * @var string
     */
    protected $holderEmail;

    /**
     * Código de autorización de la operación.
     *
     * @var string
     */
    protected $authorizationCode;

    /**
     * Marca de tarjeta utilizada en el pago.
     *
     * @var string
     */
    protected $cardBrand;

    /**
     * Últimos 4 dígitos de la tarjeta utilizada en el pago.
     *
     * @var string
     */
    protected $cardLastFourDigits;

    /**
     * Importe total pagado. En general este atributo será igual al atributo
     * amount del objeto Result. Sin embargo, en aquellos casos donde el pagador
     * haya optado por pagar en cuotas que impliquen interés financiero, los
     * valores podrán diferir.
     *
     * @var float
     */
    protected $amount;

    /**
     * Cantidad de cuotas seleccionadas para el pago.
     *
     * @var int
     */
    protected $installments;

    /**
     * Importe estimado de cada cuota. Este valor es redondeado a 2 decimales
     * pudiendo generar desviaciones en cualquier cálculo. Se recomienda solo
     * utilizarlo de manera informativa.
     *
     * @var float
     */
    protected $installmentAmount;


    /**
     * @return string
     */
    public function getHolderName(): string
    {
        return $this->holderName;
    }

    /**
     * @return string
     */
    public function getHolderEmail(): string
    {
        return $this->holderEmail;
    }

    /**
     * @return string
     */
    public function getAuthorizationCode(): string
    {
        return $this->authorizationCode;
    }

    /**
     * @return string
     */
    public function getCardBrand(): string
    {
        return $this->cardBrand;
    }

    /**
     * @return string
     */
    public function getCardLastFourDigits(): string
    {
        return $this->cardLastFourDigits;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getInstallments(): int
    {
        return $this->installments;
    }

    /**
     * @return float
     */
    public function getInstallmentAmount(): float
    {
        return $this->installmentAmount;
    }
}
