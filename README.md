# Bug report for symfony/symfony

We want to report a bug to symfony/symfony repository regarding `ErrorListener` & `error_controller` usage resulting in having the wrong request method.

## Description

When we use `symfony/symfony` and configure the `error_controller` in the `config/packages/framework.yaml` file, when we get the `request_method`, there is an specific case where the `request_method` it's always `GET`.

## Repository usage

This repository is used to reproduce the bug.

1. Clone the repository
2. Run `composer install`
3. Run the tests with `./vendor/bin/phpunit`

## Steps to reproduce

1. Create a new symfony project
2. Configure the `ErrorListener` and `error_controller` in the `config/packages/framework.yaml` file
3. Create a new controller with a POST endpoint that throws a BadRequestHttpException
4. Make a POST request to the endpoint
5. Check the `request_method` in the `error_controller`
6. The `request_method` is set to `GET` when it should be `POST` in `$request->getMethod()`

## Expected behavior

The `request_method` should be set to `POST`