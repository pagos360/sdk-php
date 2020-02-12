<?php

namespace Pagos360\Models;

class Adhesion extends AbstractModel
{
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
     * Este atributo se puede utilizar como referencia para identificar la
     * Solicitud de Pago y sincronizar con tus sistemas de backend el origen de
     * la operación. Algunos valores comunmente utilizados son: ID de Cliente,
     * DNI, CUIT, ID de venta o Nro. de Factura entre otros.
     *
     * @var string|null
     */
    protected $externalReference;

    /**
     * Número de CBU de la cuenta bancaria en la que se ejecutarán los débitos.
     *
     * @var string
     */
    protected $cbuNumber;

    /**
     * CUIT/CUIL del títular de la cuenta bancaria.
     *
     * @var int
     */
    protected $cbuHolderIdNumber;

    /**
     * Nombre del titular de la cuenta bancaria.
     *
     * @var string
     */
    protected $cbuHolderName;

    /**
     * Email del del titular de la cuenta bancaria.
     *
     * @var string
     */
    protected $email;

    /**
     * Nombre de la entidad bancaria a la que corresponde el número de CBU.
     *
     * @var string
     */
    protected $bank;

    /**
     * Descripción o concepto de la Adhesión.
     *
     * @var string
     */
    protected $description;

    /**
     * Descripción Bancaria que se mostrará en el resumen de la cuenta bancaria
     * del pagador.
     *
     * @var string
     */
    protected $shortDescription;

    /**
     * Motivo de cancelación de una Adhesión. Si esta presente, este valor
     * indica porque la adhesion ha sido cancelada.
     *
     * @var string|null
     */
    protected $stateComment;


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
     * @return string
     */
    public function getAdhesionHolderName(): string
    {
        return $this->adhesionHolderName;
    }

    /**
     * @param string $adhesionHolderName
     * @return self
     */
    public function setAdhesionHolderName(string $adhesionHolderName): self
    {
        $this->adhesionHolderName = $adhesionHolderName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExternalReference(): ?string
    {
        return $this->externalReference;
    }

    /**
     * @param string|null $externalReference
     * @return self
     */
    public function setExternalReference(?string $externalReference): self
    {
        $this->externalReference = $externalReference;
        return $this;
    }

    /**
     * @return string
     */
    public function getCbuNumber(): string
    {
        return $this->cbuNumber;
    }

    /**
     * @param string $cbuNumber
     * @return self
     */
    public function setCbuNumber(string $cbuNumber): self
    {
        $this->cbuNumber = $cbuNumber;
        return $this;
    }

    /**
     * @return int
     */
    public function getCbuHolderIdNumber(): int
    {
        return $this->cbuHolderIdNumber;
    }

    /**
     * @param int $cbuHolderIdNumber
     * @return self
     */
    public function setCbuHolderIdNumber(int $cbuHolderIdNumber): self
    {
        $this->cbuHolderIdNumber = $cbuHolderIdNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getCbuHolderName(): string
    {
        return $this->cbuHolderName;
    }

    /**
     * @param string $cbuHolderName
     * @return self
     */
    public function setCbuHolderName(string $cbuHolderName): self
    {
        $this->cbuHolderName = $cbuHolderName;
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
    public function getBank(): string
    {
        return $this->bank;
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
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     * @return self
     */
    public function setShortDescription(string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStateComment(): ?string
    {
        return $this->stateComment;
    }
}
