# Pagos360 SDK PHP

SDK para realizar transacciones por medio de Pagos360

- [Instalación](#instalación)
- [Introducción](#introducción)

  - [Inicialización](#inicialización)

- [Modelos](#modelos)

  - [Solicitud de Pago](#solicitud-de-pago) (`PaymentRequest`)

    - [Crear](#crear)
    - [Buscar por id](#buscar-por-id)
    - [Resultados](#resultados)
    - [Funciones de utilidad](#funciones-de-utilidad)

  - [Solicitud de Débito en CBU](#solicitud-de-débito-en-cbu) (`DebitRequest`)

    - [Crear](#crear-1)
    - [Buscar por id](#buscar-por-id-1)
    - [Resultados](#resultados-1)
    - [Cancelar](#cancelar)

  - [Adhesion en CBU](#adhesion-en-cbu) (`Adhesion`)

    - [Crear](#crear-2)
    - [Buscar por id](#buscar-por-id-2)
    - [Cancelar](#cancelar-1)

  - [Solicitud de Débito en Tarjeta](#solicitud-de-débito-en-tarjeta) (`CardDebitRequest`)

    - [Crear](#crear-3)
    - [Buscar por id](#buscar-por-id-3)
    - [Resultados](#resultados-2)

  - [Adhesion en Tarjeta](#adhesion-en-tarjeta) (`CardAdhesion`)

    - [Crear](#crear-4)
    - [Buscar por id](#buscar-por-id-4)
    - [Cancelar](#cancelar-2)

  - [Reporte de Cobranza](#reporte-de-cobranza) (`CollectionReport`)
    - [Buscar por fecha](#buscar-por-fecha)
    - [Datos](#datos)
  - [Reporte de Reversiones](#reporte-de-reversiones) (`ChargebackReport`)
    - [Buscar por fecha](#buscar-por-fecha-1)
    - [Datos](#datos-1)
  - [Reporte de Rendicion](#reporte-de-rendicion) (`SettlementReport`)

    - [Buscar por fecha](#buscar-por-fecha-2)
    - [Datos](#datos-2)

  - [Cuenta](#cuenta) (`Account`)

- [Otros](#otros)
  - [Logs](#logs)

# Instalación

La instalación se debe hacer mediante [Composer](http://getcomposer.org/) con el siguiente comando:

```bash
composer require pagos360/sdk-php
```

# Introducción

Este SDK actúa de forma similar a un ORM, usando un diseño similar a los repositorios para generar objetos nativos en base de las respuestas JSON de la API.

Si bien el objetivo del SDK es simplificar el proceso de integración, no es un reemplazo de la [Documentación para Desarrolladores](https://developers.pagos360.com/).

## Inicialización

Para empezar a utilizar el SDK desde su código, se provee una clase `\Pagos360\Sdk`, la cual toma como único parámetro una _API KEY_ generada desde el menú de _Integraciones_ desde el portal web de Pagos360.

```php
$sdk = new \Pagos360\Sdk('API_KEY_VALUE');
```
O si tenes una variable de entorno configurada
```php
$sdk = new \Pagos360\Sdk(getenv('API_KEY_VAR_NAME'));
```

Para comprobar que la _API KEY_ esté configurada correctamente, se puede utilizar el repositorio de cuenta.

```php
$account = $sdk->account->get();
var_dump($account);
```

En caso que todo sea correcto, `$account` debería ser una instancia de la clase `\Pagos360\Models\Account`.

# Modelos

## Solicitud de Pago

[Conceptos generales](https://developers.pagos360.com/endpoints/payment-request/conceptos-generales)

### Crear

[Documentación](https://developers.pagos360.com/endpoints/payment-request/post_payment-request)

```php
$paymentRequest = new \Pagos360\Models\PaymentRequest();
$paymentRequest
    ->setFirstTotal(13.53)
    ->setFirstDueDate(new DateTimeImmutable('tomorrow'))
    ->setDescription('Creada por SDK')
    ->setPayerName('Matias Pino')
;

$paymentRequest = $sdk->paymentRequests->create($paymentRequest);
```

#### Excluir canales

Para facilitar la exclusión de canales, se proveen constantes dentro de la clase `\Pagos360\Constants`. Como la plataforma de Pagos360 se encuentra en desarrollo activo, es probable que en el futuro se agreguen más tipos de canales que aun no estén soportados en el SDK. En ese caso, se puede usar una string representando el nuevo valor.

```php
$paymentRequest->setExcludedChannels([
    \Pagos360\Constants::CHANNEL_CREDIT_CARD,
    'tipo_de_canal_nuevo',
]);
```

#### Excluir cuotas

Números de las cuotas que serán omitidas de las opciones al pagador (Solo aplica para el medio de pago Tarjeta de Crédito).

```php
$paymentRequest->setExcludedInstallments([1, 3, 6]));
```

#### Excluir tarjetas

Códigos de las tarjetas que serán omitdas de las opciones al pagador. Valores posibles: campo code del endpoint Obtener Planes y Cuotas (Solo aplica para el medio de pago Tarjeta de Crédito). 

### Buscar por id

[Documentación](https://developers.pagos360.com/endpoints/payment-request/get_payment-request-id)

```php
$paymentRequest = $sdk->paymentRequests->get(179960);
```

#### Resultados

[Documentación](https://developers.pagos360.com/endpoints/payment-request/get_payment-request-id#atributos-del-objeto-request_result)

Los resultados de una Solicitud de Pago estan encapsulados en un objeto de tipo `\Doctrine\Common\Collections\ArrayCollection`, el cual contiene una colección de instancias del modelo `\Pagos360\Models\Result`. En caso que la solicitud no tenga ningun resultado, este metodo devolvera `null`.

```php
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
```

### Funciones de utilidad

#### Verificar que la solicitud haya sido pagada

```php
$paymentRequest = $sdk->paymentRequests->get(179960);
$isPaid = $sdk->paymentRequests->isPaid($paymentRequest);
```

Alternativamente, se puede usar esta funcion que tira una excepcion en caso que no haya sigo pagada.

```php
$paymentRequest = $sdk->paymentRequests->get(179960);
$sdk->paymentRequests->assertIsPaid($paymentRequest);
```

## Solicitud de Débito en CBU

[Conceptos generales](https://developers.pagos360.com/endpoints/debito-automatico/debit-request/conceptos-generales)

### Crear

[Documentación](https://developers.pagos360.com/endpoints/debito-automatico/debit-request/post-debit-request)

```php
$request = new \Pagos360\Models\DebitRequest();
$request
    ->setAdhesion($adhesion)
    ->setFirstDueDate(new DateTimeImmutable('+1 month'))
    ->setFirstTotal(13.53)
;

$sdk->debitRequests->create($request);
```

Si bien es recomendable obtener la adhesion y verificar que siga en el estado firmada, es posible generar un mock de una Adhesion de la siguiente forma:

```php
$request->setAdhesion(new \Pagos360\Models\Adhesion(['id' => 25]))
```

### Buscar por id

[Documentación](https://developers.pagos360.com/endpoints/debito-automatico/debit-request/get-debit-request-id)

```php
$debitRequest = $sdk->debitRequests->get(182760);
```

#### Resultados

[Documentación](https://developers.pagos360.com/endpoints/debito-automatico/debit-request/get-debit-request-id#atributos-del-objeto-request_result)

Los resultados de una Solicitud de Débito estan encapsulados en un objeto de tipo `\Doctrine\Common\Collections\ArrayCollection`, el cual contiene una colección de instancias del modelo `Result`. En caso que la solicitud no tenga ningun resultado, este metodo devolvera `null`.

```php
$debitRequest = $sdk->debitRequests->get(185027);

$collectedResult = $sdk->debitRequests->findCollectedResult($debitRequest);
echo sprintf(
    'Solicitud de Debito %s pagada. Monto: $%s.%s',
    $paymentRequest->getId(),
    $collectedResult->getAmount(),
    PHP_EOL
);
```

### Cancelar

[Documentación](https://developers.pagos360.com/endpoints/debito-automatico/debit-request/put-debit-request)

```php
$originalDebitRequest = $sdk->debitRequests->get($debitRequestId);
$debitRequest = $sdk->debitRequests->cancel($originalDebitRequest);
```

## Adhesion en CBU

[Conceptos generales](https://developers.pagos360.com/endpoints/debito-automatico/adhesions/conceptos-generales)

### Crear

[Documentación](https://developers.pagos360.com/endpoints/debito-automatico/adhesions/conceptos-generales)

```php
$adhesion = new \Pagos360\Models\Adhesion();
$adhesion
    ->setAdhesionHolderName('Matias Pino')
    ->setExternalReference('8354')
    ->setCbuNumber('0000000000000000000000')
    ->setCbuHolderIdNumber(11111111)
    ->setCbuHolderName('Matias Pino')
    ->setEmail('pagos360@example.com')
    ->setDescription('Creada por SDK')
    ->setShortDescription('P360')
;

$adhesion = $sdk->adhesions->create($adhesion);
```

### Buscar por id

[Documentación](https://developers.pagos360.com/endpoints/debito-automatico/adhesions/get-adhesion-id)

```php
$adhesion = $sdk->adhesions->get(25);
```

### Cancelar

[Documentación](https://developers.pagos360.com/endpoints/debito-automatico/adhesions/put-adhesion)

```php
$adhesion = $sdk->adhesions->get(25);
$adhesion = $sdk->adhesions->cancel($adhesion);
```

## Solicitud de Débito en Tarjeta

### Crear

[Documentación](https://developers.pagos360.com/endpoints/debito-automatico/debit-request/put-debit-request)

```php
$cardAdhesion = $sdk->cardAdhesions->get(1488);

$cardDebitRequest = new \Pagos360\Models\CardDebitRequest();
$cardDebitRequest
    ->setCardAdhesion($cardAdhesion)
    ->setMonth(4)
    ->setYear(2021)
    ->setAmount(13.53)
;
$cardDebitRequest = $sdk->cardDebitRequests->create($cardDebitRequest);
```

### Buscar por id

[Documentación](https://developers.pagos360.com/endpoints/debito-automatico-tarjeta/card-debit-request/get_card-debit-request-id)

```php
$cardDebitRequest = $sdk->cardDebitRequests->get(652641);
```

#### Resultados

### Cancelar

[Documentación](https://developers.pagos360.com/endpoints/debito-automatico/debit-request/put-debit-request)

```php
$cardDebitRequest = $sdk->cardDebitRequests->get(652641);
$cardDebitRequest = $sdk->cardDebitRequests->cancel($cardDebitRequest);
```

## Adhesion en Tarjeta

### Crear

[Documentación](https://developers.pagos360.com/endpoints/debito-automatico-tarjeta/card-adhesions/post_card-adhesion)

```php
$cardAdhesion = new \Pagos360\Models\CardAdhesion();
$cardAdhesion
    ->setAdhesionHolderName('Matias Pino')
    ->setEmail('pagos360@example.com')
    ->setDescription('Creada por SDK')
    ->setExternalReference('210000013847')
    ->setCardNumber()
    ->setCardHolderName('Matias Pino')
;
$cardAdhesion = $sdk->cardAdhesions->create($cardAdhesion);
```

### Buscar por id

[Documentación](https://developers.pagos360.com/endpoints/debito-automatico-tarjeta/card-adhesions/get_card-adhesion)

```php
$cardAdhesion = $sdk->cardAdhesions->get(1467);
```

### Cancelar

[Documentación](https://developers.pagos360.com/endpoints/debito-automatico-tarjeta/card-adhesions/put_adhesion)

```php
$cardAdhesion = $sdk->cardAdhesions->get(1467);
$sdk->cardAdhesions->cancel($ad);
```

## Reporte de Cobranza

### Buscar por fecha

[Documentación](https://developers.pagos360.com/endpoints/reports/get_collection-report)

```php
$collectionReport = $sdk->collectionReports->get(
    new DateTimeImmutable('2018-11-29')
);
```

#### Datos

[Documentación](https://developers.pagos360.com/endpoints/reports/get_collection-report#data)

Los datos de un Reporte de Cobranza estan encapsulados en un objeto de tipo `\Doctrine\Common\Collections\ArrayCollection`, el cual contiene una colección de instancias del modelo `\Pagos360\Models\CollectionData`.

```php
foreach ($collectionReport->getData() as $data) {
    /** @var \Pagos360\Models\CollectionData $data */
    $paymentDate = $data->getPaymentDate();
}
```

## Reporte de Reversiones

### Buscar por fecha

[Documentación](https://developers.pagos360.com/endpoints/reports/get_chargeback-report)

```php
$chargebackReport = $sdk->chargebackReports->get(
    new DateTimeImmutable('2018-11-29')
);
```

#### Datos

Los datos de un Reporte de Cobranza estan encapsulados en un objeto de tipo `\Doctrine\Common\Collections\ArrayCollection`, el cual contiene una colección de instancias del modelo `\Pagos360\Models\ChargebackData`.

```php
foreach ($chargebackReport->getData() as $data) {
   /** @var \Pagos360\Models\ChargebackData $data */
       $requestId = $data->getRequestId(),
   );
}
```

## Reporte de Rendicion

### Buscar por fecha

[Documentación](https://developers.pagos360.com/endpoints/reports/get_settlement-report)

```php
$settlementReport = $sdk->settlementReports->get(
    new DateTimeImmutable('2019-04-16')
);
```

#### Datos

[Documentación](https://developers.pagos360.com/endpoints/reports/get_settlement-report#data)

Los datos de un Reporte de Cobranza estan encapsulados en un objeto de tipo `\Doctrine\Common\Collections\ArrayCollection`, el cual contiene una colección de instancias del modelo `\Pagos360\Models\SettlementData`.

```php
foreach ($settlementReport->getData() as $data) {
   /** @var \Pagos360\Models\SettlementData $data */
       $requestId = $data->getRequestId(),
   );
}
```

## Cuenta

[Conceptos generales](https://developers.pagos360.com/endpoints/account/conceptos-generales)

### Obtener

[Documentación](https://developers.pagos360.com/endpoints/account/cuenta)

```php
$account = $sdk->account->get();
```

# Otros

## Logs

La clase SDK, RestClient, y los repositorios implementan la interfaz `LoggerAwareInterface` del [PSR-3](https://www.php-fig.org/psr/psr-3/).

```php
$logger = new \Monolog\Logger('Pagos360 SDK');
$logger->pushHandler(new \Monolog\Handler\StreamHandler(STDOUT));

$sdk->setLogger($logger);
```

En caso de querer usar distintos loggers para las distintas partes, se puede especificar de la siguiente forma:

```php
$restClientLogger = new \Monolog\Logger('Pagos360 RestClient');
$sdk->getRestClient()->setLogger($restClientLogger);

$paymentRequestLogger = new \Monolog\Logger('Pagos360 PaymentRequest');
$sdk->paymentRequests->setLogger($paymentRequestLogger);
```

Tambien existe el metodo `setLoggerAndPropagate` en el SDK que replica el logger al RestClient y todos los repositorios.

```php
$logger = new \Monolog\Logger('Pagos360 SDK');
$logger->pushHandler(new \Monolog\Handler\StreamHandler(STDOUT));

$sdk->setLoggerAndPropagate($logger);
```

En estos ejemplos se usa la libreria `Monolog`, pero se puede usar cualquier libreria que implemente los metodos declarados en `LoggerInterface` de dicho PSR.
