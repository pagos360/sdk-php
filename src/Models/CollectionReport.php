<?php

namespace Pagos360\Models;

use Doctrine\Common\Collections\ArrayCollection;

class CollectionReport extends AbstractModel
{
    /**
     * ID de la cuenta propietaria del Reporte.
     *
     * @var string
     */
    protected $accountId;

    /**
     * Fecha en la que se informaron los Cobros.
     *
     * @var \DateTimeImmutable
     */
    protected $reportDate;

    /**
     * Importe Total Cobrado.
     *
     * @var float
     */
    protected $totalCollected;

    /**
     * Importe Total de Comisión.
     *
     * @var float
     */
    protected $totalGrossFee;

    /**
     * Importe Total por Acreditar. Equivalente a Importe Total Cobrado menos
     * Importe Total de Comisión.
     *
     * @var float
     */
    protected $totalNetAmount;

    /**
     * Arreglo de Objetos que contiene las Solicitudes de Pago Cobradas.
     *
     * @var ArrayCollection
     */
    protected $data;

    /**
     * @return string
     */
    public function getAccountId(): string
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
     * @return float
     */
    public function getTotalCollected(): float
    {
        return $this->totalCollected;
    }

    /**
     * @return float
     */
    public function getTotalGrossFee(): float
    {
        return $this->totalGrossFee;
    }

    /**
     * @return float
     */
    public function getTotalNetAmount(): float
    {
        return $this->totalNetAmount;
    }

    /**
     * @return ArrayCollection
     */
    public function getData(): ArrayCollection
    {
        return $this->data;
    }
}
