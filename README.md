# prex-challenge-api

Prex PHP challenge. Integration with Giphy API.

## Local Development

Requirements

- PHP 8.3, with the following extras
  - php8.3-xml, php8.3-curl, php8.3-sqlite3, php8.3-mysql, php8.3-mbstring
  - php composer
- Docker and docker-compose plugin

Copy `.env.example` file to a new `.env` file and optionally adjust project configuration. `GIPHY_API_KEY` value is required.

To start a development server, run: 

```shell
composer install
php artisan migrate --seed
php artisan serve
```

## Testing

To run all tests, execute:

```shell
./vendor/bin/phpunit
```

## Docker

To start app in docker containers

```shell
# start app and db images
docker compose up -d

# open shell inside app container image
docker compose run app sh
# from inside app container image
php artisan migrate --seed
```

## Postman Collection

[link json export](https://github.com/tehuel/prex-challenge-api/raw/main/.github/prex-challenge-api.postman_collection.json)

## Diagrams

### Use Cases Diagram

![](https://github.com/tehuel/prex-challenge-api/blob/main/.github/prex-use-case.drawio.png?raw=true)

[link](https://github.com/tehuel/prex-challenge-api/blob/main/.github/prex-use-case.drawio.png)

### Sequence Diagrams

#### Authenticate

![](https://github.com/tehuel/prex-challenge-api/blob/main/.github/prex-seq-auth.drawio.png?raw=true)

[link](https://github.com/tehuel/prex-challenge-api/blob/main/.github/prex-seq-auth.drawio.png)

#### Search

![](https://github.com/tehuel/prex-challenge-api/blob/main/.github/prex-seq-search.drawio.png?raw=true)

[link](https://github.com/tehuel/prex-challenge-api/blob/main/.github/prex-seq-search.drawio.png)

#### Get Single Gif

![](https://github.com/tehuel/prex-challenge-api/blob/main/.github/prex-seq-get.drawio.png?raw=true)

[link](https://github.com/tehuel/prex-challenge-api/blob/main/.github/prex-seq-get.drawio.png)

#### Add GIF to Favorites

![](https://github.com/tehuel/prex-challenge-api/blob/main/.github/prex-seq-fav.drawio.png?raw=true)

[link](https://github.com/tehuel/prex-challenge-api/blob/main/.github/prex-seq-fav.drawio.png)

### Entity Relationship Diagram

![](https://github.com/tehuel/prex-challenge-api/blob/main/.github/prex-erd.drawio.png?raw=true)

[link](https://github.com/tehuel/prex-challenge-api/blob/main/.github/prex-erd.drawio.png)

