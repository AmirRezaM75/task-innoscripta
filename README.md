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

## API

Download and import [postman collection](./storage/Innoscripta.postman_collection.json) located at `storage/` directory.

## Switch Search Engine

We can switch between MySQL and Elasticsearch in case of outage.

possible values: `mysql`, `elasticsearch`

```
SEARCH_ENGINE=elasticsearch
```

## Schedules

To avoid creating a dedicated docker image which contains [supervisor](https://supervisord.org/), to make the scheduler
up and running just run following command:

```
php artisan schedule:run
```

## User Preferences

Before seeding user preferences data, make sure to run one of [commands](#commands) mentioned above.

```
php artisan db:seed
```
