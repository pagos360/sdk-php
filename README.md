# Pagos360 SDK PHP

SDK para realizar transacciones por medio de Pagos360

Módulo para conexión con Pagos360

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
    - [Resultados](#resultados)

  - [Solicitud de Débito](#solicitud-de-débito) (`DebitRequest`)

    - [Crear](#crear-1)
    - [Buscar por id](#buscar-por-id-1)
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

Para empezar a utilizar el SDK desde su código, se provee una clase `\Pagos360\Sdk`, la cual toma como único parámetro una _API KEY_ generada desde el menú de _Integraciones_ desde el portal web de Pagos360.

```php
$sdk = new \Pagos360\Sdk(getenv('PAGOS360_API_KEY'));
```

Para comprobar que la _API KEY_ esté configurada correctamente, se puede utilizar el repositorio de cuenta.

```php
$account = $sdk->account->get();
var_dump($account);
```

En caso que todo sea correcto, `$account` debería ser una instancia de la clase `\Pagos360\Models\Account`.

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

Para facilitar la exclusión de canales, se proveen constantes dentro de la clase `\Pagos360\Constants`. Como la plataforma de Pagos360 se encuentra en desarrollo activo, es probable que en el futuro se agreguen más tipos de canales que aun no estén soportados en el SDK. En ese caso, se puede usar una string representando el nuevo valor.

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
