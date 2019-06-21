<?php

namespace Pagos360\Models;

class HolderData extends AbstractModel
{
    /**
     * Nombre del pagador de la Solicitud de Pago.
     *
     * @var string
     */
    protected $name;

    /**
     * Email del pagador de la Solicitud de Pago.
     *
     * @var string
     */
    protected $email;


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
