<?php

require_once 'vendor/autoload.php';

$sdk = new \Pagos360\Sdk(getenv('PAGOS360_API_KEY'));

$firstPage = $sdk->adhesions->getPage(null);

foreach ($firstPage->getData() as $adhesion) {
    echo $adhesion->getState();
    echo PHP_EOL;
}
