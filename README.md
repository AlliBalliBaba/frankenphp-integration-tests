# FrankenPHP Integration Tests

This repo serves as a small sandbox for automated testing of FrankenPHP with various extensions and 
Symfony/Laravel as frameworks.
It's main purpose is to make new FrankenPHP branches more resilient against bugs.

## Setup

To run the tests you need `git`, `docker` and `docker compose`.
The FrankenPHP image will be installed from a git branch of your choosing.

To set up the local `frankenphp-custom-with-extensions` image:

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
in `laravel/tests`.

The tests are running in parallel through `PHPUnit`, `paratest` and the Guzzle `CurlMultiHandler`

## Running tests manually

To view the caddy output while testing, you can instead call `frankenphp run`:

```bash
docker compose up -d
docker compose exec frankenphp frankenphp run -c /app/Caddyfile
```

And then run the tests from a separate terminal while watching the output:

```bash
docker compose exec frankenphp vendor/bin/paratest -v
```

You can also filter for single tests

```bash
docker compose exec frankenphp vendor/bin/paratest --filter=OpenSSL
```

## Benchmarks

You can run quick benchmarks and create flamegraphs with:

```bash
sh benchmark
```

and

```bash
sh flame
```
