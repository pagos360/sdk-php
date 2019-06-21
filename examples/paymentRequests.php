<?php

require_once 'vendor/autoload.php';

$sdk = new \Pagos360\Sdk(getenv('PAGOS360_API_KEY'));

################################################################################
# Creation                                                                     #
################################################################################
//$request = new \Pagos360\Models\PaymentRequest();
//$request
//    ->setFirstTotal(13.53)
//    ->setFirstDueDate(new DateTimeImmutable('1 month'))
//    ->setDescription('Example from the PHP SDK')
//    ->setPayerName('Matias Pino')
//;
//
//$savedRequest = $sdk->paymentRequests->create($request);
//
//echo sprintf('Solicitud de Pago %s creada.%s', $savedRequest->getId(), PHP_EOL);

################################################################################
# Handling missing required fields                                             #
################################################################################
//$request = new \Pagos360\Models\PaymentRequest();
//$request
//    ->setFirstTotal(13.53)
//;
//
//try {
//    $sdk->paymentRequests->create($request);
//} catch (\Pagos360\Exceptions\MissingRequiredInputException $exception) {
//    $data = $exception->getData();
//    error_log(sprintf(
//        'El campo `%s` del modelo `%s` es requerido.',
//        $data['field'],
//        get_class($data['model'])
//    ));
//}

################################################################################
# Holder data                                                                  #
################################################################################
//$paymentRequest = $sdk->paymentRequests->get(234741);
//
//$holderData = $paymentRequest->getHolderData();
//if (!empty($holderData)) {
//    echo sprintf(
//        'Pagada por %s (email %s).%s',
//        $holderData->getName(),
//        $holderData->getEmail(),
//        PHP_EOL
//    );
//}

################################################################################
# Results                                                                      #
################################################################################
$paymentRequest = $sdk->paymentRequests->get(234741);

$collectedResult = $sdk->paymentRequests->findCollectedResult($paymentRequest);
echo sprintf(
    'Solicitud de Pago %s pagada mediante %s. Monto: $%s.%s',
    $paymentRequest->getId(),
    $collectedResult->getChannel(),
    $collectedResult->getAmount(),
    PHP_EOL
);

$metadata = $collectedResult->getPaymentMetadata();
if (!empty($metadata)) {
    echo sprintf(
        'Pagada con tarjeta terminada en %s. Cuotas: %s ($%s).%s',
        $metadata->getCardLastFourDigits(),
        $metadata->getInstallments(),
        $metadata->getInstallmentAmount(),
        PHP_EOL
    );
}



################################################################################
# Get page                                                                     #
################################################################################
//$paginatedResponse = $sdk->debitRequests->getPage(1);
//$debitRequests = $paginatedResponse->getData();
//
//var_dump($debitRequests);
