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
php artisan app:import-news-api-sources
```

## Fetch NewsApi articles
```bash
php artisan app:fetch-news-api-articles
```
