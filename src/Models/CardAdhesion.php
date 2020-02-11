<?php

namespace Pagos360\Models;

class CardAdhesion extends AbstractModel
{
    /**
     * Nombre del titular del servicio que se debitará.
     *
     * @var string
     */
    protected $adhesionHolderName;

    /**
     * Email del titular de la Tarjeta.
     *
     * @var string
     */
    protected $email;

    /**
     * Descripción o concepto de la Adhesión.
     *
     * @var string
     */
    protected $description;

    /**
     * Este atributo se puede utilizar como referencia para identificar la
     * Adhesión y sincronizar con tus sistemas de backend el origen de la
     * operación. Algunos valores comúnmente utilizados son: ID de Cliente, DNI,
     * CUIT, ID de venta o Nro. de Factura entre otros.
     *
     * @var string
     */
    protected $externalReference;

    /**
     * Hash en Base64 que contiene la Encriptación del Número de Tarjeta en la
     * que se ejecutarán los débitos automáticos.
     *
     * @var string
     */
    protected $cardNumber;

    /**
     * Nombre del titular de la Tarjeta.
     *
     * @var string
     */
    protected $cardHolderName;

    /**
     * Objeto JSON que se puede utilizar para guardar atributos adicionales en
     * la adhesión y poder sincronizar con tus sistemas de backend.
     * Pagos360.com no utiliza este objeto. // @todo review el type
     *
     * @var array|null
     */
    protected $metadata;

    /**
     * ID de Adhesión.
     *
     * @var int
     */
    protected $id;

    /**
     * Ultimos 4 numeros de la Tarjeta.
     *
     * @var string
     */
    protected $lastFourDigits;

    /**
     * Marca de la Tarjeta.
     *
     * @var string
     */
    protected $card;

    /**
     * Estado de la Adhesión.
     *
     * @var string
     */
    protected $state;

    /**
     * Fecha y hora de creación.
     *
     * @var \DateTimeImmutable
     */
    protected $createdAt;

    /**
     * Motivo de cancelación de una Adhesión.
     *
     * @var string|null
     */
    protected $stateComment;

    /**
     * Fecha y hora de cancelación.
     *
     * @var \DateTimeImmutable|null
     */
    protected $canceledAt;

    /**
     * @return string
     */
    public function getAdhesionHolderName(): string
    {
        return $this->adhesionHolderName;
    }

    /**
     * @param string $adhesionHolderName
     * @return CardAdhesion
     */
    public function setAdhesionHolderName(string $adhesionHolderName): CardAdhesion
    {
        $this->adhesionHolderName = $adhesionHolderName;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return CardAdhesion
     */
    public function setEmail(string $email): CardAdhesion
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return CardAdhesion
     */
    public function setDescription(string $description): CardAdhesion
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getExternalReference(): string
    {
        return $this->externalReference;
    }

    /**
     * @param string $externalReference
     * @return CardAdhesion
     */
    public function setExternalReference(string $externalReference): CardAdhesion
    {
        $this->externalReference = $externalReference;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    /**
     * @param string $cardNumber
     * @return CardAdhesion
     */
    public function setCardNumber(string $cardNumber): CardAdhesion
    {
        $this->cardNumber = $cardNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardHolderName(): string
    {
        return $this->cardHolderName;
    }

    /**
     * @param string $cardHolderName
     * @return CardAdhesion
     */
    public function setCardHolderName(string $cardHolderName): CardAdhesion
    {
        $this->cardHolderName = $cardHolderName;
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
     * @param array $metadata
     * @return CardAdhesion
     */
    public function setMetadata(array $metadata): CardAdhesion
    {
        $this->metadata = $metadata;
        return $this;
    }

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
    public function getLastFourDigits(): string
    {
        return $this->lastFourDigits;
    }

    /**
     * @return string
     */
    public function getCard(): string
    {
        return $this->card;
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
     * @return string|null
     */
    public function getStateComment(): ?string
    {
        return $this->stateComment;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getCanceledAt(): ?\DateTimeImmutable
    {
        return $this->canceledAt;
    }
}
