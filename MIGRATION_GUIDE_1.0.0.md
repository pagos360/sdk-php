# Guia de migracion a la version 1.0.0

## Metodos eliminados

### Repositorios

- \Pagos360\Repositories\PaymentRequestRepository:
  - getPage()
  - getFilteredPage()
  - listGenerator()
- \Pagos360\Repositories\DebitRequestRepository:
  - getPage()
  - getFilteredPage()
- \Pagos360\Repositories\AdhesionRepository:
  - getPage()
  - getFilteredPage()
- \Pagos360\Repositories\AbstractRepository:
  - getPage()
  - getFilteredPage()

### Modelos

- \Pagos360\Models\Account:
  - getType()
  - getAvailableChannelTypes()
- \Pagos360\Models\DebitRequest:
  - getDescription()
  - setDescription()

## Clases (y sus respectivas constantes y metodos) elimadas:

- \Pagos360\Filters\PaymentRequestFilters
- \Pagos360\Filters\DebitRequestFilters
- \Pagos360\Filters\AdhesionFilters
- \Pagos360\Filters\AbstractFilters
- \Pagos360\Pagination
- \Pagos360\PaginatedResponse

## Constantes eliminadas:

- \Pagos360\Repositories\PaymentRequestRepository::DEFAULT_ITEMS_PER_PAGE
- \Pagos360\Repositories\DebitRequestRepository::DEFAULT_ITEMS_PER_PAGE
- \Pagos360\Repositories\AdhesionRepository::DEFAULT_ITEMS_PER_PAGE

## Modificaciones:

- El metodo `setLogger()` de la clase `\Pagos360\Sdk` solo configura el logger para dicha clase. En caso de querer configurar el mismo logger para todas las clases, se puede usar el nuevo metodo `setLoggerAndPropagate()`.
- Se renombro la constante (en \Pagos360\Constants) ADHESION_STATE_PENDING_TO_SIGN a ADHESION_PENDING_TO_SIGN_STATE
- Se renombro la constante (en \Pagos360\Constants) ADHESION_STATE_SIGNED a ADHESION_SIGNED_STATE
- Se renombro la constante (en \Pagos360\Constants) ADHESION_STATE_CANCELED a ADHESION_CANCELED_STATE
