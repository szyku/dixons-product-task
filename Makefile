# You need docker to make this work
PHP_IMAGE =  docker run --rm -it -w /usr/src/myapp -v ${PWD}:/usr/src/myapp --user 1000:1000 php:7-alpine3.6
USER = 1000
GROUP = 1000

install:
	docker run --rm -v ${PWD}:/app --user ${USER}:${GROUP} composer composer install

.PHONY: unit
unit:
	${PHP_IMAGE} bin/phpunit

describe_spec:
	${PHP_IMAGE} bin/phpspec d "${WHAT}"

.PHONY: check_spec
check_spec:
	${PHP_IMAGE} bin/phpspec r --format=pretty

custom_php_exec:
	${PHP_IMAGE} ${WHAT}

test:
	make unit
	make check_spec
