# Changelog

All notable changes to `kong` package will be documented in this file.

## v0.2.1
* Fix: Url's including dash are split incorrect (#1)

## v0.2.0

* Laravel 5.7 compatible
* Make HttpClient parameter order consistent with query and headers at the end
* Add documentation to the code
* Fix: Data not set on `Service` when data was given as a string
* Fix: Set the default service path to `/`
* Fix: Key-auth calling wrong url on kong causing key auth to throw exception
* Fix: Recursive infinite loop when deleting consumers
* Add: Key auth creation now accepts array, string or KeyAuthConsumer instance.
* Add: global plugins API
* Add: KONG_ENABLE config options (for use by the consumers to disable kong calls)
* Added more integration tests for most api's using docker
