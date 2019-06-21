<?php

require_once 'vendor/autoload.php';

$sdk = new \Pagos360\Sdk(getenv('PAGOS360_API_KEY'));

$account = $sdk->account->get();

var_dump($account);
