# Pagos360.com SDK PHP

SDK para realizar transacciones por medio de Pagos360.com

Módulo para conexión con Pagos360.com

- [Instalación](#instalación)
- [Introducción](#introducción)

  - [Inicialización](#inicialización)
  - [Paginación](#paginación)
  - [Filtros](#filtros)
  - [Resultados](#resultados)

- Modelos

  - [Solicitud de Pago](#solicitud-de-pago) (`PaymentRequest`)

    - [Crear](#crear)
    - [Buscar por id](#buscar-por-id)
    - [Listar](#listar)
    - [Listar con filtros](#listar-con-filtros)
    - [Resultados](#resultados)

  - [Solicitud de Débito](#solicitud-de-débito) (`DebitRequest`)

    - [Crear](#crear-1)
    - [Buscar por id](#buscar-por-id-1)
    - [Listar](#listar-1)
    - [Listar con filtros](#listar-con-filtros-1)
    - [Resultados](#resultados-1)

  - Adhesion (`Adhesion`)
  - Cuenta (`Account`)

- Otros
  - [Logs](#logs)

# Instalación

La instalación se debe hacer mediante [Composer](http://getcomposer.org/) con el siguiente comando:

```bash
composer require pagos360/sdk
```

# Introducción

Este SDK actua de forma similar a un ORM, usando un diseño similar a los repositorios para generar objetos nativos en base de las respuestas JSON de la API.

Si bien el objetivo del SDK es simplificar el proceso de integración, no es un reemplazo de la [Documentación para Desarrolladores](https://developers.pagos360.com/).

## Inicialización

Para empezar a utilizar el SDK desde su código, se provee una clase `\Pagos360\Sdk`, la cual toma como único parámetro una _API KEY_ generada desde el menú de _Integraciones_ desde el portal web de Pagos360.com

```php
$sdk = new \Pagos360\Sdk(getenv('PAGOS360_API_KEY'));
```

Para comprobar que la _API KEY_ esté configurada correctamente, se puede utilizar el repositorio de cuenta.

```php
$account = $sdk->account->get();
var_dump($account);
```

En caso que todo sea correcto, `$account` debería ser una instancia de la clase `\Pagos360\Models\Account`.

## Paginación

Aquellos endpoints que listan modelos devuelven un objeto del tipo `\Pagos360\PaginatedResponse`, el cual tiene dos metodos: `getPagination()` que devuelve un objeto de tipo `\Pagos360\Pagination` con la data de la paginación y `getData()` que contiene un objeto de tipo `\Doctrine\Common\Collections\ArrayCollection` con todas las entidades correspondientes.

## Filtros

Los endpoints de listados también cuentan con la funcionalidad de poder aplicar filtros. Para esto se usa su respectiva clases de filtros (por ejemplo `PaymentRequestFilters`), la cual contiene constantes que asisten en la traduccion al tipo de filtro correspondiente.

```
$filters = new PaymentRequestFilters([
    PaymentRequestFilters::STATE => "paid",
    PaymentRequestFilters::CREATED_AT_GTE => new DateTimeImmutable('17-07-2018'),
    PaymentRequestFilters::CREATED_AT_LTE => new DateTimeImmutable('17-07-2018'),
]);
```

Como la plataforma de Pagos360.com se encuentra en desarrollo activo, es probable que en el futuro la API provea filtros que no esten soportados nativamente en este SDK. En ese caso, se puede proveer un filtro sin usar la constante, basandose en la documentación oficial. Por ejemplo:

```
$filters = new PaymentRequestFilters([
    PaymentRequestFilters::STATE => "paid",
    "filtro_nuevo" => "valor",
]);
```

# Solicitud de Pago

## Crear

[Documentación](https://developers.pagos360.com/api/endpoints/payment-request/post_payment-request)

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

### Excluir canales

Para facilitar la exclusión de canales, se proveen constantes dentro de la clase `\Pagos360\Constants`. Al igual que los filtros, puede ser que en un futuro se agreguen más tipos de canales que aun no estén soportados en el SDK. En ese caso, se puede usar una string representando el nuevo valor.

```php
$paymentRequest->setExcludedChannelTypes([
    \Pagos360\Constants::CHANNEL_CREDIT_CARD,
    'tipo_de_canal_nuevo',
]);
```

## Buscar por id

[Documentación](https://developers.pagos360.com/api/endpoints/payment-request/get_payment-request-id)

```php
$paymentRequest = $sdk->paymentRequests->get(179960);
```

## Listar

[Documentación](https://developers.pagos360.com/api/endpoints/payment-request/get-payment-request)

```php
$paginatedResponse = $sdk->paymentRequests->getPage(1);
$paginationData = $paginatedResponse->getPagination();
/** @var \Pagos360\Models\PaymentRequest[] $paymentRequests */
$paymentRequests = $paginatedResponse->getData();

var_dump($paymentRequests);
var_dump($paginationData);
```

## Listar con filtros

```php
$filters = new PaymentRequestFilters([
    PaymentRequestFilters::STATE => "paid",
    PaymentRequestFilters::CREATED_AT_GTE => new DateTimeImmutable('yesterday'),
    PaymentRequestFilters::CREATED_AT_LTE => new DateTimeImmutable('yesterday'),
]);

$paginatedPaymentRequests = $sdk->paymentRequests->getFiltereredPage(
    $filters,
    5,
    25
);
/** @var \Pagos360\Models\PaymentRequest[] $paymentRequests */
$paymentRequests = $paginatedPaymentRequests->getData();
```

### Filtros disponibles

| Nombre                                     | Tipo     | Query param         |
| ------------------------------------------ | -------- | ------------------- |
| PaymentRequestFilters::EXTERNAL_REFERENCE  | string   | external_reference  |
| PaymentRequestFilters::STATE               | string   | state               |
| PaymentRequestFilters::CREATED_AT_LTE      | DateTime | created_at_lte      |
| PaymentRequestFilters::CREATED_AT_GTE      | DateTime | created_at_gte      |
| PaymentRequestFilters::FIRST_DUE_DATE_LTE  | DateTime | first_due_date_lte  |
| PaymentRequestFilters::FIRST_DUE_DATE_GTE  | DateTime | first_due_date_gte  |
| PaymentRequestFilters::FIRST_TOTAL_LTE     | float    | first_total_lte     |
| PaymentRequestFilters::FIRST_TOTAL_GTE     | float    | first_total_gte     |
| PaymentRequestFilters::SECOND_DUE_DATE_LTE | DateTime | second_due_date_lte |
| PaymentRequestFilters::SECOND_DUE_DATE_GTE | DateTime | second_due_date_gte |
| PaymentRequestFilters::SECOND_TOTAL_LTE    | float    | second_total_lte    |
| PaymentRequestFilters::SECOND_TOTAL_GTE    | float    | second_total_gte    |
| PaymentRequestFilters::PAYER_NAME          | string   | payer_name          |

## Resultados

[Documentación](https://developers.pagos360.com/api/endpoints/payment-request/conceptos-generales#atributos-del-objeto-request_result)

Los resultados de una Solicitud de Pago estan encapsulados en un objeto de tipo `\Doctrine\Common\Collections\ArrayCollection`, la cual contiene una colección de instancias del model `Result`. En caso que la solicitud no tenga ningun resultado, este metodo devolvera `null`.

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

## Funciones de utilidad

### Verificar que la solicitud haya sido pagada

```php
$paymentRequest = $sdk->paymentRequests->get(179960);
$isPaid = $sdk->paymentRequests->isPaid($paymentRequest);
```

Alternativamente, se puede usar esta funcion que tira una excepcion en caso que no haya sigo pagada.

```php
$paymentRequest = $sdk->paymentRequests->get(179960);
$sdk->paymentRequests->assertIsPaid($paymentRequest);
```

# Solicitud de Débito

## Crear

[Documentación](https://developers.pagos360.com/api/endpoints/debito-automatico/debit-request/post-debit-request)

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

## Buscar por id

[Documentación](https://developers.pagos360.com/api/endpoints/debito-automatico/debit-request/get-debit-request-id)

```php
$debitRequest = $sdk->debitRequests->get(182760);
```

## Listar

[Documentación](https://developers.pagos360.com/api/endpoints/debito-automatico/debit-request/get-debit-request)

```php
$paginatedResponse = $sdk->debitRequests->getPage(1);
$paginationData = $paginatedResponse->getPagination();
/** @var \Pagos360\Models\DebitRequest[] $debitRequests */
$debitRequests = $paginatedResponse->getData();

var_dump($debitRequests);
var_dump($paginationData);
```

## Listar con filtros

```php
$filters = new \Pagos360\Filters\DebitRequestFilters([
    \Pagos360\Filters\DebitRequestFilters::STATE => \Pagos360\Constants::DEBIT_REQUEST_PAID_STATE,
]);
$paginatedResponse = $sdk->debitRequests->getFilteredPage($filters, 1);
$paginationData = $paginatedResponse->getPagination();
/** @var \Pagos360\Models\DebitRequest[] $debitRequests */
$debitRequests = $paginatedResponse->getData();

var_dump($debitRequests);
var_dump($paginationData);
```

### Filtros disponibles

| Nombre                                    | Tipo     | Query param          |
| ----------------------------------------- | -------- | -------------------- |
| DebitRequestFilters::EXTERNAL_REFERENCE   | string   | external_reference   |
| DebitRequestFilters::STATE                | string   | state                |
| DebitRequestFilters::CREATED_AT_LTE       | DateTime | created_at_lte       |
| DebitRequestFilters::CREATED_AT_GTE       | DateTime | created_at_gte       |
| DebitRequestFilters::FIRST_DUE_DATE_LTE   | DateTime | first_due_date_lte   |
| DebitRequestFilters::FIRST_DUE_DATE_GTE   | DateTime | first_due_date_gte   |
| DebitRequestFilters::FIRST_TOTAL_LTE      | float    | first_total_lte      |
| DebitRequestFilters::FIRST_TOTAL_GTE      | float    | first_total_gte      |
| DebitRequestFilters::SECOND_DUE_DATE_LTE  | DateTime | second_due_date_lte  |
| DebitRequestFilters::SECOND_DUE_DATE_GTE  | DateTime | second_due_date_gte  |
| DebitRequestFilters::SECOND_TOTAL_LTE     | float    | second_total_lte     |
| DebitRequestFilters::SECOND_TOTAL_GTE     | float    | second_total_gte     |
| DebitRequestFilters::ADHESION_HOLDER_NAME | string   | adhesion_holder_name |

## Resultados

[Documentación](https://developers.pagos360.com/api/endpoints/payment-request/conceptos-generales#atributos-del-objeto-request_result)

Los resultados de una Solicitud de Débito estan encapsulados en un objeto de tipo `\Doctrine\Common\Collections\ArrayCollection`, la cual contiene una colección de instancias del model `Result`. En caso que la solicitud no tenga ningun resultado, este metodo devolvera `null`.

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

# Adhesiones

## Creación

```php
$adhesion = new \Pagos360\Models\Adhesion();
$adhesion
    ->setAdhesionHolderName('Matias Pino')
    ->setExternalReference('8354')
    ->setCbuNumber('0070196530004025671477')
    ->setCbuHolderIdNumber(33387275)
    ->setCbuHolderName('Matias Pino')
    ->setEmail('mpino@pagos360.com')
    ->setDescription('Creada por SDK')
    ->setShortDescription('P360')
;

$adhesion = $sdk->adhesions->create($adhesion);
```

## Buscar por id

```php
$adhesion = $sdk->adhesions->get(25);
```

````

# Logs

La clase SDK, RestClient, y los repositorios implementan la interfaz `LoggerAwareInterface` del [PSR-3
el `logger` va a ser replicado al resto de las clases internas.

```php
$logger = new \Monolog\Logger('Pagos360 SDK');
$logger->pushHandler(new \Monolog\Handler\StreamHandler(STDOUT));

$sdk->setLogger($logger);
````

En caso de querer usar distintos loggers para las distintas partes, se puede especificar de la siguiente forma:

```php
$restClientLogger = new \Monolog\Logger('Pagos360 RestClient');
$sdk->getRestClient()->attachLogger($restClientLogger);

$paymentRequestLogger = new \Monolog\Logger('Pagos360 PaymentRequest');
$sdk->paymentRequests->attachLogger($paymentRequestLogger);
```

En estos ejemplos se usa la libreria `Monolog`, pero se puede usar cualquier libreria que implemente las reglas del [PSR-3](https://www.php-fig.org/psr/psr-3/).
