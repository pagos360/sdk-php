<?php

namespace Pagos360\Exceptions;

class MissingRequiredInputException extends AbstractException
{
    /**
     * @var string
     */
    public $message = 'Unable to save model due to a missing required field';
}
