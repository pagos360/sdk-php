<?php

namespace Pagos360\Models;

use Doctrine\Common\Collections\ArrayCollection;

class PaymentRequest extends AbstractModel
{
    /**
     * ID de Solicitud de Pago.
     *
     * @var int
     */
    protected $id;

    /**
     * Estado de la Solicitud de Pago.
     * Los posibles valores son: "pending", "paid", "expired", "reverted".
     *
     * @var string
     */
    protected $state;

    /**
     * Fecha y hora de creación.
     *
     * @var \DateTimeInterface
     */
    protected $createdAt;

    /**
     * Descripción o concepto de la Solicitud de Pago.
     *
     * @var string
     */
    protected $description;

    /**
     * Este atributo se puede utilizar como referencia para identificar la
     * Solicitud de Pago y sincronizar con tus sistemas de backend el origen de
     * la operación. Algunos valores comunmente utilizados son: ID de Cliente,
     * DNI, CUIT, ID de venta o Número de Factura, entre otros.
     *
     * @var string|null
     */
    protected $externalReference;

    /**
     * Fecha de vencimiento de la Solicitud de Pago.
     *
     * @var \DateTimeInterface
     */
    protected $firstDueDate;

    /**
     * Importe a cobrar.
     *
     * @var float
     */
    protected $firstTotal;

    /**
     * Fecha de segundo vencimiento de la Solicitud de Pago.
     *
     * @var \DateTimeInterface|null
     */
    protected $secondDueDate;

    /**
     * Importe a cobrar pasada la primera fecha de vencimiento.
     *
     * @var float|null
     */
    protected $secondTotal;

    /**
     * Nombre del destinatario de la Solicitud de Pago.
     *
     * @var string
     */
    protected $payerName;

    /**
     * Email del destinatario de la Solicitud de Pago.
     *
     * @var string|null
     */
    protected $payerEmail;

    /**
     * Objeto JSON que se puede utilizar para guardar atributos adicionales en
     * la solicitud de pago y poder sincronizar con tus sistemas de backend.
     * Pagos360.com no utiliza este objeto.
     *
     * @var array|null
     */
    protected $metadata;

    /**
     * Código númerico del código de barra.
     *
     * @var string
     */
    protected $barcode;

    /**
     * URL para instanciar el checkout de pago online.
     *
     * @var string
     */
    protected $checkoutUrl;

    /**
     * URL de la imágen del código de barra utilizado para pagar en las redes
     * de pago en efectivo.
     *
     * @var string
     */
    protected $barcodeUrl;

    /**
     * URL de cupón de pago en formato pdf.
     *
     * @var string
     */
    protected $pdfUrl;

    /**
     * En el caso de estar especificado el pagador será redirigido a esta URL
     * ante un pago exitoso.
     *
     * @var string|null
     */
    protected $backUrlSuccess;

    /**
     * En el caso de estar especificado el pagador será redirigido a esta URL
     * ante un pago pendiente.
     *
     * @var string|null
     */
    protected $backUrlPending;

    /**
     * En el caso de estar especificado el pagador será redirigido a esta URL
     * ante un pago rechazado.
     *
     * @var string|null
     */
    protected $backUrlRejected;

    /**
     * Tipos de Medios de Pago que serán omitidos de las opciones al pagador.
     * Valores posibles: "banking", "credit_card", "debit_card", "link_pagos" y
     * "non_banking".
     *
     * @var string[]|null
     */
    protected $excludedChannelTypes;

    /**
     * @var HolderData|null
     */
    protected $holderData;

    /**
     * @var ArrayCollection|null
     */
    protected $results;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExternalReference(): ?string
    {
        return $this->externalReference;
    }

    /**
     * @param string|null $externalReference
     * @return self
     */
    public function setExternalReference(?string $externalReference): self
    {
        $this->externalReference = $externalReference;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getFirstDueDate(): \DateTimeInterface
    {
        return $this->firstDueDate;
    }

    /**
     * @param \DateTimeInterface $firstDueDate
     * @return self
     */
    public function setFirstDueDate(\DateTimeInterface $firstDueDate): self
    {
        $this->firstDueDate = $firstDueDate;
        return $this;
    }

    /**
     * @return float
     */
    public function getFirstTotal(): float
    {
        return $this->firstTotal;
    }

    /**
     * @param float $firstTotal
     * @return self
     */
    public function setFirstTotal(float $firstTotal): self
    {
        $this->firstTotal = $firstTotal;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getSecondDueDate(): ?\DateTimeInterface
    {
        return $this->secondDueDate;
    }

    /**
     * @param \DateTimeInterface|null $secondDueDate
     * @return self
     */
    public function setSecondDueDate(?\DateTimeInterface $secondDueDate): self
    {
        $this->secondDueDate = $secondDueDate;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getSecondTotal(): ?float
    {
        return $this->secondTotal;
    }

    /**
     * @param float|null $secondTotal
     * @return self
     */
    public function setSecondTotal(?float $secondTotal): self
    {
        $this->secondTotal = $secondTotal;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayerName(): string
    {
        return $this->payerName;
    }

    /**
     * @param string $payerName
     * @return self
     */
    public function setPayerName(string $payerName): self
    {
        $this->payerName = $payerName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPayerEmail(): ?string
    {
        return $this->payerEmail;
    }

    /**
     * @param string|null $payerEmail
     * @return self
     */
    public function setPayerEmail(?string $payerEmail): self
    {
        $this->payerEmail = $payerEmail;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getMetadata(): ?array
    {
        return $this->metadata;
    }

    /**
     * @param array|null $metadata
     * @return self
     */
    public function setMetadata(?array $metadata): self
    {
        $this->metadata = $metadata;
        return $this;
    }

    /**
     * @return string
     */
    public function getBarcode(): string
    {
        return $this->barcode;
    }

    /**
     * @return string
     */
    public function getCheckoutUrl(): string
    {
        return $this->checkoutUrl;
    }

    /**
     * @return string
     */
    public function getBarcodeUrl(): string
    {
        return $this->barcodeUrl;
    }

    /**
     * @return string
     */
    public function getPdfUrl(): string
    {
        return $this->pdfUrl;
    }

    /**
     * @return string|null
     */
    public function getBackUrlSuccess(): ?string
    {
        return $this->backUrlSuccess;
    }

    /**
     * @param string|null $backUrlSuccess
     * @return self
     */
    public function setBackUrlSuccess(?string $backUrlSuccess): self
    {
        $this->backUrlSuccess = $backUrlSuccess;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBackUrlPending(): ?string
    {
        return $this->backUrlPending;
    }

    /**
     * @param string|null $backUrlPending
     * @return self
     */
    public function setBackUrlPending(?string $backUrlPending): self
    {
        $this->backUrlPending = $backUrlPending;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBackUrlRejected(): ?string
    {
        return $this->backUrlRejected;
    }

    /**
     * @param string|null $backUrlRejected
     * @return self
     */
    public function setBackUrlRejected(?string $backUrlRejected): self
    {
        $this->backUrlRejected = $backUrlRejected;
        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getExcludedChannelTypes(): ?array
    {
        return $this->excludedChannelTypes;
    }

    /**
     * @param string[]|null $excludedChannelTypes
     * @return self
     */
    public function setExcludedChannelTypes(?array $excludedChannelTypes): self
    {
        $this->excludedChannelTypes = $excludedChannelTypes;
        return $this;
    }

    /**
     * @return HolderData|null
     */
    public function getHolderData(): ?HolderData
    {
        return $this->holderData;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getResults(): ?ArrayCollection
    {
        return $this->results;
    }
}
