<?php

namespace Pagos360\Models;

class AbstractAdhesion extends AbstractModel {
    /**
     * ID de Adhesión.
     *
     * @var int
     */
    protected $id;

    /**
     * Estado de la Adhesión.
     * Los posibles valores son: "pending_to_sign", "signed", "canceled".
     *
     * @var string
     */
    protected $state;

    /**
     * Fecha y hora de creación.
     *
     * @var \DateTimeInterface
     */
    protected $createdAt;

    /**
     * Nombre del titular del servicio que se debitará.
     *
     * @var string
     */
    protected $adhesionHolderName;

    /**
     * Motivo de cancelación de una Adhesión.
     *
     * @var string|null
     */
    protected $stateComment;

    /**
     * Fecha y hora de cancelación. Si está presente, este valor
     * indica la fecha en que la adhesion ha sido cancelada.
     *
     * @var \DateTimeInterface|null
     */
    protected $canceledAt;

    /**
     * Objeto JSON que se puede utilizar para guardar atributos adicionales en
     * la adhesión y poder sincronizar con tus sistemas de backend.
     * Pagos360.com no utiliza este objeto.
     *
     * @var array|null
     */
    protected $metadata;

    /**
     * Descripción o concepto de la Adhesión.
     *
     * @var string
     */
    protected $description;

    /**
     * Email del del titular de la cuenta bancaria.
     *
     * @var string
     */
    protected $email;

    /**
     * Este atributo se puede utilizar como referencia para identificar la
     * Adhesión y sincronizar con tus sistemas de backend el origen de
     * la operación. Algunos valores comunmente utilizados son: ID de Cliente,
     * DNI, CUIT, ID de venta o Nro. de Factura entre otros.
     *
     * @var string|null
     */
    protected $externalReference;

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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): self
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
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCanceledAt(): ?\DateTimeInterface
    {
        return $this->canceledAt;
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
     * @return self
     */
    public function setMetadata(?array $metadata): self
    {
        $this->metadata = $metadata;
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
     * @return self
     */
    public function setExternalReference(string $externalReference): self
    {
        $this->externalReference = $externalReference;
        return $this;
    }



}