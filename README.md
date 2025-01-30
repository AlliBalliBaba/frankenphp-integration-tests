# FrankenPHP Integration Tests

This repo serves as a small sandbox for automated testing of FrankenPHP + Laravel with various extensions.
It's main purpose is to make new FrankenPHP branches more resilient against bugs.

## Setup

To run the tests you need `git`, `docker` and `docker compose`.
The FrankenPHP image will be installed from a git branch of your choosing.

To setup the local `frankenphp-custom-with-extensions` image:

```bash
sh setup
```

To add additional extensions, you can modify the `frankenphp.Dockerfile` and run setup again.

## Test

To run tests:

```bash
sh test
```

This will start the custom `FrankenPHP` image, `PostgreSQL`, `MySQL`, `Redis` and run the tests
in the `Laravel` repo.

The tests are running in parallel through `PHPUnit` and `paratest` (`laravel/tests`)
They are mainly calling the controllers in the `laravel/app//Http/Controllers` directory.
Most tests will make ~100 requests in parallel

### Caddyfile

You can edit the `Caddyfile` in the root of the repo or add additonal Caddyfiles to test
different configurations.

## Running single tests

To run single tests, you can start the server manually and adjust the `--filter`:

```bash
docker compose up -d
docker compose exec frankenphp frankenphp start -c /app/Caddyfile
docker compose exec frankenphp php artisan test --filter=OpenSSL
```

## Viewing Caddy output

To view the caddy output while testing, you can instead call `frankenphp run`:

```bash
docker compose exec frankenphp frankenphp start -c /app/Caddyfile
```

And the run the tests from a separate shell while watching the output:

```bash
docker compose exec frankenphp vendor/bin/paratest -p 4 -v
```