<?php

namespace Pagos360\Models;

class SettlementData extends AbstractModel
{
    /**
     * ID de la Solicitud de Pago.
     *
     * @var int
     */
    protected $requestId;

    /**
     * Este atributo es utilizado como referencia para identificar la Solicitud
     * de Pago y sincronizar con tus sistemas de backend el origen de la
     * operación. Algunos valores comunmente utilizados son: ID de Cliente, DNI,
     * CUIT, ID de venta o Nro. de Factura entre otros.
     *
     * @var string
     */
    protected $externalReference;

    /**
     * Importe de la Solicitud Pago Cobrada.
     *
     * @var float
     */
    protected $credit;

    /**
     * Importe de la Solicitud de Pago Revertida.
     *
     * @var float
     */
    protected $debit;
}
