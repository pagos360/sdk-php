<?php

namespace Pagos360\Exceptions\Adhesions;

use Pagos360\Exceptions\AbstractException;
use Pagos360\Models\Adhesion;
use Throwable;

class AdhesionNotSignedException extends AbstractException
{
    /**
     * @var Adhesion
     */
    private $adhesion;

    /**
     * @param Adhesion       $adhesion
     * @param Throwable|null $previous
     */
    public function __construct(
        Adhesion $adhesion,
        Throwable $previous = null
    ) {
        $this->adhesion = $adhesion;
        $data = [
            'adhesion' => $adhesion,
        ];

        parent::__construct($data, $previous);
    }

    /**
     * @return Adhesion
     */
    public function getAdhesion(): Adhesion
    {
        return $this->adhesion;
    }
}
