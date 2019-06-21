<?php

namespace Pagos360\Exceptions;

class UnrecognizedModelException extends AbstractException
{
    /**
     * @var string
     */
    public $message = 'This given entity is not an instance we recognize';
}
