# Dixons task implementation

Author: Szymon Szymański [szymon dot szymanski at hotmail dot com]

## Prerequisites

- PHP 7.2
- composer

Optionally docker to reuse Makefile and commands.

## Installation

There's just composer needed to run this.

Global composer:

```bash
composer install
```

Using composer via docker image:

```bash
# PWD = the directory where composer.* files are placed
docker run --rm -v $PWD:/app --user $(id -u):$(id -g) composer composer install

```

Or use make with docker:
```bash
make install
```

## How to run

```bash
php -S localhost:8000 -t public/
```

## Tests

Global PHP (7.2+)
```bash
bin/phpunit
```

Or use make with docker:
```bash
make unit
make check_spec
# Or everything
make test
```

## Troubleshooting

### Wrong file permissions after using make commands

Seems your User ID and Group ID doesn't match with the one in the script.

**Solution** : Edit the Makefile and change USER and GROUP vars to appropriate. 