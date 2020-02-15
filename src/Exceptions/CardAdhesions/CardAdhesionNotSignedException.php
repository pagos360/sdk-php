<?php

namespace Pagos360\Exceptions\CardAdhesions;

use Pagos360\Exceptions\AbstractException;
use Pagos360\Models\CardAdhesion;
use Throwable;

class CardAdhesionNotSignedException extends AbstractException
{
    /**
     * @var CardAdhesion
     */
    private $cardAdhesion;

    /**
     * @param CardAdhesion   $cardAdhesion
     * @param Throwable|null $previous
     */
    public function __construct(
        CardAdhesion $cardAdhesion,
        Throwable $previous = null
    ) {
        $this->cardAdhesion = $cardAdhesion;
        $data = [
            'paymentRequest' => $cardAdhesion,
        ];

        parent::__construct($data, $previous);
    }

    /**
     * @return CardAdhesion
     */
    public function getCardAdhesion(): CardAdhesion
    {
        return $this->cardAdhesion;
    }
}
