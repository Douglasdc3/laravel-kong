# A Kong Admin Client for laravel apps

This is laravel package that allows you to integrate with [kong](https://getkong.org). An open source API manager build on NGINX.

# Install

This package requires PHP7 and Laravel5.6 or higher.

```bash
composer required douglasdc3/kong
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
* Documentation.

# Testing & local development

Starting a local kong instance

```bash
docker-compose up -d postgres
# The first time you need to run the database migrations
docker-compose run --rm kong kong migrations up
docker-compose up -d kong
```

Run the tests with:

```bash
vendor/bin/phpunit
```
