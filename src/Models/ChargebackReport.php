<?php

namespace Pagos360\Models;

use Doctrine\Common\Collections\ArrayCollection;

class ChargebackReport extends AbstractModel
{
    /**
     * ID de la cuenta propietaria del Reporte.
     *
     * @var String
     */
    protected $accountId;

    /**
     * Fecha en la que se informaron las Reversiones.
     *
     * @var \DateTimeImmutable
     */
    protected $reportDate;

    /**
     * Importe Total Revertido.
     *
     * @var Float
     */
    protected $totalChargeback;

    /**
     * Arreglo de Objetos que contiene las Solicitudes de Pago Revertidas.
     *
     * @var ArrayCollection
     */
    protected $data;

    /**
     * @return String
     */
    public function getAccountId(): String
    {
        return $this->accountId;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getReportDate(): \DateTimeImmutable
    {
        return $this->reportDate;
    }

    /**
     * @return Float
     */
    public function getTotalChargeback(): Float
    {
        return $this->totalChargeback;
    }

    /**
     * @return ArrayCollection
     */
    public function getData(): ArrayCollection
    {
        return $this->data;
    }
}
