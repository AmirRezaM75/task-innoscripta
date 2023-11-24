# Innoscripta

## Setup

```bash
docker compose up -d
docker compose exec fpm composer install
docker compose exec php artisan migrate
```

## Commands

## Fetch NewsApi sources

Before fetching articles we must fetch sources.
```bash
php artisan app:import-newsapi-sources
```

## Fetch NewsApi articles

```bash
php artisan app:import-newsapi-articles --from 2023-11-23 --to 2023-11-23
```

## Fetch The Guardian articles

```bash
php artisan app:import-guardian-articles
```

## Fetch The New York Times articles

```bash
php artisan app:import-nytimes-articles
```
