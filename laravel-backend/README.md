# GPAO Laravel Backend Skeleton

Contenu fourni:
- Migrations GPAO
- Models Eloquent
- Services métier (`WorkOrderService`, `StockService`)
- Controllers API (`Product`, `WorkOrder`, `Dashboard`)
- Seeder initial (`GpaoSeeder`)
- Routes API sécurisées via Sanctum

## Intégration
Copier les fichiers dans un projet Laravel existant, puis:
1. `php artisan migrate`
2. `php artisan db:seed --class=GpaoSeeder`

## Endpoints clés
- `POST /api/work-orders`
- `POST /api/work-orders/{id}/release`
- `POST /api/work-orders/{id}/report`
- `GET /api/dashboard/kpis`
