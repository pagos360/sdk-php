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
     * Estados de una Adhesion.
     */
    const ADHESION_STATE_PENDING_TO_SIGN = 'pending_to_sign';
    const ADHESION_STATE_SIGNED = 'signed';
    const ADHESION_STATE_CANCELED = 'canceled';

    /**
     * Estas constantes facilitan la exclusión de canales al momento de crear
     * una Solicitud de Pago.
     */
    const CHANNEL_CREDIT_CARD = 'credit_card';
    const CHANNEL_DEBIT_CARD = 'debit_card';
    const CHANNEL_NON_BANKING = 'non_banking';
    const CHANNEL_BANKING = 'banking';

    /**
     * Tipos de Cuenta en Pagos360
     */
    const ACCOUNT_CURRENT = 'current_account';
    const ACCOUNT_CONSOLIDATED = 'consolidated_account';
}
