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

This will start the custom FrankenPHP image, PostgreSQL, MySQL, Redis and run the tests
in the Laravel repo.
