<?php

namespace Pagos360\Models;

class CardDebitRequest extends AbstractModel
{
    /**
     * ID de la Solicitud de Débito en Tarjeta.
     *
     * @var int
     */
    protected $id;

    /**
     * Tipo de Solicitud.
     *
     * @var string
     */
    protected $type;

    /**
     * Estado de la Solicitud de Débito en Tarjeta.
     *
     * @var string
     */
    protected $state;

    /**
     * Fecha y hora de creación del la Solicitud.
     *
     * @var \DateTimeImmutable
     */
    protected $createdAt;

    /**
     * Importe a ser Debitado.
     *
     * @var float
     */
    protected $amount;

    /**
     * Mes en el que se ejecuta el Debito Automático. Formato: mm.
     *
     * @var int
     */
    protected $month;

    /**
     * Año en el que se ejecuta el Debito Automático. Formato: aaaa.
     *
     * @var int
     */
    protected $year;

    /**
     * Objeto JSON que se puede utilizar para guardar atributos adicionales
     * en la Solicitud de Débito y poder sincronizar con tus sistemas de
     * backend. Pagos360 no utiliza este objeto.
     *
     * @var array|null
     */
    protected $metadata; // @todo review

    /**
     * Descripción o concepto de la Solicitud de Débito.
     *
     * @var string|null
     */
    protected $description;

    /**
     * Objeto con el detalle de la Adhesión en Tarjeta.
     *
     * @var CardAdhesion
     */
    protected $cardAdhesion;

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
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return CardDebitRequest
     */
    public function setAmount(float $amount): CardDebitRequest
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * @param int $month
     * @return CardDebitRequest
     */
    public function setMonth(int $month): CardDebitRequest
    {
        $this->month = $month;
        return $this;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     * @return CardDebitRequest
     */
    public function setYear(int $year): CardDebitRequest
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getMetadata(): ?array
    {
        return $this->metadata;
    }

    /**
     * @param array|null $metadata
     * @return CardDebitRequest
     */
    public function setMetadata(?array $metadata): CardDebitRequest
    {
        $this->metadata = $metadata;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return CardDebitRequest
     */
    public function setDescription(string $description): CardDebitRequest
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return CardAdhesion
     */
    public function getCardAdhesion(): CardAdhesion
    {
        return $this->cardAdhesion;
    }

    /**
     * @param CardAdhesion $cardAdhesion
     * @return CardDebitRequest
     */
    public function setCardAdhesion(CardAdhesion $cardAdhesion): CardDebitRequest
    {
        $this->cardAdhesion = $cardAdhesion;
        return $this;
    }
}
