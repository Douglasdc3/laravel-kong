# A Kong Admin Client for laravel apps

This is laravel package that allows you to integrate with [kong](https://getkong.org). An open source API manager build on NGINX.

# Install

This package requires PHP7.X and Laravel5.6 or higher.

```bash
composer require douglasdc3/kong
```

# Usage

This library follows Kong's api.

Example request:

```php
$kong = new Kong(new HttpClient('http://localhost:8001'));
$consumer = new Consumer(['username' => 'johndoe', 'custom_id' => 123]);
// Creating a new Consumer & add user to admin acl group in kong
$kong->consumers()->create($consumer)->acl()->create('admin');
````

# Planned development

* Missing plugins.
* More tests.

# Testing & local development

The integration test use docker behind the scenes.
Run the tests with:

```bash
vendor/bin/phpunit
```
