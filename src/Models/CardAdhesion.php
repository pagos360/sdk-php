<?php

namespace Pagos360\Models;

class CardAdhesion extends AbstractAdhesion
{
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
     * @return string|null
     */
    public function getStateComment(): ?string
    {
        return $this->stateComment;
    }

}
