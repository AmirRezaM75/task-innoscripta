# Innoscripta

## Setup

Clone the project:

```
git clone git@github.com:AmirRezaM75/task-innoscripta.git
```

Set your environment:

```
cp .env.example .env
```

Update credentials:

```
NEW_YORK_TIMES_TOKEN=
GUARDIAN_TOKEN=
NEWS_API_TOKEN=
DB_USERNAME=
DB_PASSWORD=
```
Just for simplicity, I've sent my credentials with the email.

Build the image and run containers:

```bash
export UID=$UID
docker compose up -d
docker compose exec fpm composer install
docker compose exec fpm php artisan migrate
```

By default, importing data into database happens asynchronously. You must run the queue worker:

```
php artisan queue:work
```

## Commands

## Fetch NewsApi sources

Before fetching articles we must fetch sources.

```bash
php artisan app:import-newsapi-sources
```

## Fetch NewsApi articles

```bash
php artisan app:import-newsapi-articles
```

## Fetch The Guardian articles

```bash
php artisan app:import-guardian-articles
```

## Fetch The New York Times articles

```bash
php artisan app:import-nytimes-articles
```

You may use `--from` and `--to` options to only fetch articles within the given timespan.

```
php artisan app:import-newsapi-articles --from 2023-11-23 --to 2023-11-23
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
