<?php

namespace Pagos360\Exceptions\RestClient;

class ForbiddenException extends ClientError
{
    /**
     * @var string
     */
    public $message = 'Forbidden';
}
