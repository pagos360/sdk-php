<?php

namespace Pagos360\Models;

class Items extends AbstractModel
{
    /**
     * Cantidad del producto o servicio.
     *
     * @var int
     */
    protected $quantity;

    /**
     * Descripción del producto o servicio (hasta 255 caracteres).
     *
     * @var string
     */
    protected $description;

    /**
     * Importe del producto o servicio. Formato: 00000000.00
     * (hasta 8 enteros y 2 decimales, utilizando punto “.”
     * como separador decimal).
     *
     * @var float
     */
    protected $amount;

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}
