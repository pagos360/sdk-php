<?php

namespace Pagos360;

abstract class Constants
{
    /**
     * Estados de una Solicitud de Pago.
     */
    const PAYMENT_REQUEST_PAID_STATE = 'paid';
    const PAYMENT_REQUEST_PENDING_STATE = 'pending';
    const PAYMENT_REQUEST_EXPIRED_STATE = 'expired';
    const PAYMENT_REQUEST_REVERTED_STATE = 'reverted';

    /**
     * Estados de una Solicitud de Débito.
     */
    const DEBIT_REQUEST_PAID_STATE = 'paid';
    const DEBIT_REQUEST_PENDING_STATE = 'pending';
    const DEBIT_REQUEST_EXPIRED_STATE = 'expired';
    const DEBIT_REQUEST_CANCELED_STATE = 'canceled';
    const DEBIT_REQUEST_REJECTED_STATE = 'rejected';
    const DEBIT_REQUEST_REVERTED_STATE = 'reverted';

    /**
     * Estados de una Solicitud de Débito en Tarjeta.
     */
    const CARD_DEBIT_REQUEST_PAID_STATE = 'paid';
    const CARD_DEBIT_REQUEST_PENDING_STATE = 'pending';
    const CARD_DEBIT_REQUEST_EXPIRED_STATE = 'expired';
    const CARD_DEBIT_REQUEST_CANCELED_STATE = 'canceled';
    const CARD_DEBIT_REQUEST_REJECTED_STATE = 'rejected';
    const CARD_DEBIT_REQUEST_REVERTED_STATE = 'reverted';

    /**
     * Estados de una Adhesion.
     */
    const ADHESION_PENDING_TO_SIGN_STATE = 'pending_to_sign';
    const ADHESION_SIGNED_STATE = 'signed';
    const ADHESION_CANCELED_STATE = 'canceled';
    const CARD_ADHESION_PENDING_TO_SIGN_STATE = 'pending_to_sign';
    const CARD_ADHESION_SIGNED_STATE = 'signed';
    const CARD_ADHESION_CANCELED_STATE = 'canceled';

    /**
     * Estas constantes facilitan la exclusión de canales al momento de crear
     * una Solicitud de Pago.
     */
    const CHANNEL_CREDIT_CARD = 'credit_card';
    const CHANNEL_DEBIT_CARD = 'debit_card';
    const CHANNEL_NON_BANKING = 'non_banking';
    const CHANNEL_BANKING = 'banking';
}
