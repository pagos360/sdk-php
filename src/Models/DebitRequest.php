<?php

namespace Pagos360\Models;

use Doctrine\Common\Collections\ArrayCollection;

class DebitRequest extends AbstractModel
{
    /**
     * ID de Solicitud de Débito.
     *
     * @var int
     */
    protected $id;

    /**
     * Estado de la Solicitud de Débito.
     * Los posibles valores son: "pending", "in_process", "paid", "reverted",
     * "canceled", "rejected".
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
     * Objeto con el detalle de la Adhesión.
     *
     * @var Adhesion
     */
    protected $adhesion;

    /**
     * Fecha de vencimiento de la Solicitud de Débito.
     *
     * @var \DateTimeInterface
     */
    protected $firstDueDate;

    /**
     * Importe a cobrar.
     *
     * @var float
     */
    protected $firstTotal;

    /**
     * Fecha de segundo vencimiento de la Solicitud de Débito.
     *
     * @var \DateTimeInterface|null
     */
    protected $secondDueDate;

    /**
     * Importe a cobrar pasada la primera fecha de vencimiento.
     *
     * @var float|null
     */
    protected $secondTotal;

    /**
     * Objeto JSON que se puede utilizar para guardar atributos adicionales en
     * la solicitud de debito y poder sincronizar con tus sistemas de backend.
     * Pagos360 no utiliza este objeto.
     *
     * @var array|null
     */
    protected $metadata;

    /**
     * Objeto con el detalle de los resultados de una Solicitud de Débito.
     *
     * @var ArrayCollection|null
     */
    protected $results;

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
     * @return Adhesion
     */
    public function getAdhesion(): Adhesion
    {
        return $this->adhesion;
    }

    /**
     * @param Adhesion $adhesion
     * @return self
     */
    public function setAdhesion(Adhesion $adhesion): self
    {
        $this->adhesion = $adhesion;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getFirstDueDate(): \DateTimeInterface
    {
        return $this->firstDueDate;
    }

    /**
     * @param \DateTimeInterface $firstDueDate
     * @return self
     */
    public function setFirstDueDate(\DateTimeInterface $firstDueDate): self
    {
        $this->firstDueDate = $firstDueDate;
        return $this;
    }

    /**
     * @return float
     */
    public function getFirstTotal(): float
    {
        return $this->firstTotal;
    }

    /**
     * @param float $firstTotal
     * @return self
     */
    public function setFirstTotal(float $firstTotal): self
    {
        $this->firstTotal = $firstTotal;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getSecondDueDate(): ?\DateTimeInterface
    {
        return $this->secondDueDate;
    }

    /**
     * @param \DateTimeInterface|null $secondDueDate
     * @return self
     */
    public function setSecondDueDate(?\DateTimeInterface $secondDueDate): self
    {
        $this->secondDueDate = $secondDueDate;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getSecondTotal(): ?float
    {
        return $this->secondTotal;
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
     * @param float|null $secondTotal
     * @return self
     */
    public function setSecondTotal(?float $secondTotal): self
    {
        $this->secondTotal = $secondTotal;
        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getResults(): ?ArrayCollection
    {
        return $this->results;
    }
}
