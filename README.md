# FrankenPHP Integration Tests

This repo serves as a sandbox for automated testing of Laravel + FrankenPHP with various extensions

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
