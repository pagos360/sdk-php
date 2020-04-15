<?php

namespace Pagos360\Models;

class Adhesion extends AbstractAdhesion
{
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
     * Nombre de la entidad bancaria a la que corresponde el número de CBU.
     *
     * @var string
     */
    protected $bank;

    /**
     * Descripción Bancaria que se mostrará en el resumen de la cuenta bancaria
     * del pagador.
     *
     * @var string
     */
    protected $shortDescription;

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
    public function getBank(): string
    {
        return $this->bank;
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
