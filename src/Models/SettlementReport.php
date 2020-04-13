<?php

namespace Pagos360\Models;

use Doctrine\Common\Collections\ArrayCollection;

class SettlementReport extends AbstractModel
{
    /**
     * ID de la cuenta propietaria del Reporte.
     *
     * @var String
     */
    protected $accountId;

    /**
     * Fecha en la que rindieron las Transacciones.
     *
     * @var \DateTimeImmutable
     */
    protected $reportDate;

    /**
     * Cantidad de Solicitudes de Pago Cobradas.
     *
     * @var Int
     */
    protected $totalCredits;

    /**
     * Importe Total de Solicitudes de Pago Cobradas.
     *
     * @var Float
     */
    protected $creditAmount;

    /**
     * Cantidad de Solicitudes de Pago Revertidas.
     *
     * @var Int
     */
    protected $totalDebits;

    /**
     * Importe Total de Solicitudes de Pago Revertidas.
     *
     * @var Float
     */
    protected $debitAmount;

    /**
     * Importe Total Rendido. (Solicitudes de Pago Cobradas menos Solicitudes de Pago Revertidas)
     *
     * @var Float
     */
    protected $settlementAmount;

    /**
     * Arreglo de Objetos que contiene las Solicitudes de Pago Rendidas/Revertidas.
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
     * @return Int
     */
    public function getTotalCredits(): Int
    {
        return $this->totalCredits;
    }

    /**
     * @return Float
     */
    public function getCreditAmount(): Float
    {
        return $this->creditAmount;
    }

    /**
     * @return Int
     */
    public function getTotalDebits(): Int
    {
        return $this->totalDebits;
    }

    /**
     * @return Float
     */
    public function getDebitAmount(): Float
    {
        return $this->debitAmount;
    }

    /**
     * @return Float
     */
    public function getSettlementAmount(): Float
    {
        return $this->settlementAmount;
    }

    /**
     * @return ArrayCollection
     */
    public function getData(): ArrayCollection
    {
        return $this->data;
    }
}
