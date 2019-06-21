# Pagos360.com SDK PHP

SDK para realizar transacciones por medio de Pagos360.com

Módulo para conexión con Pagos360.com

- [Instalación](#instalacion)
- [Introducción](#introduccion)
  - [Inicialización](#inicialización)
  - [Paginación](#paginación)
  - [Filtros](#filtros)
- Modelos
  - [Solicitud de Pago](#solicitud-de-pago) (`PaymentRequest`)
  - Solicitud de Débito (`DebitRequest`)
  - Adhesion (`Adhesion`)
  - Cuenta (`Account`)
- Otros
  - [Logs](#logs)

# Instalación

La instalación se debe hacer mediante [Composer](http://getcomposer.org/) con el siguiente comando:

```bash
composer require pagos360/sdk-php
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

## Creación

[Documentacion](https://developers.pagos360.com/api/endpoints/payment-request/post_payment-request)

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

### Buscar por id

[Documentacion](https://developers.pagos360.com/api/endpoints/payment-request/get_payment-request-id)

```php
$paymentRequest = $sdk->paymentRequests->get(179960);
```

## Listado

[Documentacion](https://developers.pagos360.com/api/endpoints/payment-request/get-payment-request)

```php
$paginatedPaymentRequests = $sdk->paymentRequests->getPage(5, 25);
$paymentRequests = $paginatedPaymentRequests->getData();
$paginationData = $paginatedPaymentRequests->getPagination(); // @todo
```

## Listado con filtros

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
$paymentRequests = $paginatedPaymentRequests->getData();
```

### Filtros disponibles

| Nombre                                     | Tipo   | Query param         |
| ------------------------------------------ | ------ | ------------------- |
| PaymentRequestFilters::EXTERNAL_REFERENCE  | string | external_reference  |
| PaymentRequestFilters::STATE               | string | state               |
| PaymentRequestFilters::CREATED_AT_LTE      | date   | created_at_lte      |
| PaymentRequestFilters::CREATED_AT_GTE      | date   | created_at_gte      |
| PaymentRequestFilters::FIRST_DUE_DATE_LTE  | date   | first_due_date_lte  |
| PaymentRequestFilters::FIRST_DUE_DATE_GTE  | date   | first_due_date_gte  |
| PaymentRequestFilters::FIRST_TOTAL_LTE     | float  | first_total_lte     |
| PaymentRequestFilters::FIRST_TOTAL_GTE     | float  | first_total_gte     |
| PaymentRequestFilters::SECOND_DUE_DATE_LTE | float  | second_due_date_lte |
| PaymentRequestFilters::SECOND_DUE_DATE_GTE | float  | second_due_date_gte |
| PaymentRequestFilters::SECOND_TOTAL_LTE    | date   | second_total_lte    |
| PaymentRequestFilters::SECOND_TOTAL_GTE    | date   | second_total_gte    |
| PaymentRequestFilters::PAYER_NAME          | string | payer_name          |

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

## Generator

@todo

Este metodo devuelve un objeto de tipo `\Doctrine\Common\Collections\ArrayCollection`.

```php
$paymentRequests = $sdk->paymentRequests->list();
foreach ($paymentRequests as $paymentRequest) {
    /** @var \Pagos360\Models\PaymentRequest $paymentRequest */
    $paymentRequest->getState();
}
```

# Logs

La clase SDK, RestClient, y los repositorios implementan la interfaz `LoggerAwareInterface` del [PSR-3](https://www.php-fig.org/psr/psr-3/). En el caso particular del SDK, el `logger` va a ser replicado al resto de las clases internas.

```php
$logger = new \Monolog\Logger('Pagos360 SDK');
$logger->pushHandler(new \Monolog\Handler\StreamHandler(STDOUT));

$sdk->setLogger($logger);
```

En caso de querer usar distintos loggers para las distintas partes, se puede especificar de la siguiente forma:

```php
$restClientLogger = new \Monolog\Logger('Pagos360 RestClient');
$sdk->getRestClient()->attachLogger($restClientLogger);

$paymentRequestLogger = new \Monolog\Logger('Pagos360 PaymentRequest');
$sdk->paymentRequests->attachLogger($paymentRequestLogger);
```

En estos ejemplos se usa la libreria `Monolog`, pero se puede usar cualquier libreria que siga las reglas del [PSR-3](https://www.php-fig.org/psr/psr-3/).
