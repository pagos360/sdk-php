<?php

namespace Pagos360\Exceptions\RestClient;

class BadRequestException extends ClientError
{
    /**
     * @var string
     */
    public $message = 'Bad Request';
}
