# Guia de migracion a la version 1.0.0

## Metodos eliminados

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
