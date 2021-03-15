#!make
include .env
export

init:
	composer install

start: init
	php -S localhost:${HTTP_PORT} -t public public/index.php


