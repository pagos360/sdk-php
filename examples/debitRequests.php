<?php

require_once 'vendor/autoload.php';

$sdk = new \Pagos360\Sdk(getenv('PAGOS360_API_KEY'));

################################################################################
# Creation                                                                     #
################################################################################
//$request = new \Pagos360\Models\DebitRequest();
//$request
//    ->setAdhesion(new \Pagos360\Models\Adhesion(['id' => 25]))
//    ->setFirstDueDate(new DateTimeImmutable('+1 month'))
//    ->setFirstTotal(13.53)
//;
//
//$sdk->debitRequests->create($request);

################################################################################
# Get page                                                                     #
################################################################################
$paginatedResponse = $sdk->debitRequests->getPage(1);
$debitRequests = $paginatedResponse->getData();

var_dump($debitRequests);
