<?php

namespace Pagos360\Exceptions\RestClient;

class UnauthorizedException extends ClientError
{
    /**
     * @var string
     */
    public $message = 'Unauthorized';
}
