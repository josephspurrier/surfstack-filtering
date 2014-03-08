SurfStack Wrapper for filter_var in PHP [![Build Status](https://travis-ci.org/josephspurrier/surfstack-filtering.png?branch=master)](https://travis-ci.org/josephspurrier/filtering)
===============================

The Validate class checks to see if the data meets certain qualifications. The
class uses the filter_var() function to provide easy to use validation filters:
* boolean
* email
* float
* int
* ip
* regexp
* url

The static methods allow you to use all the options and flags available. There
are tests included so you can see exactly what validates and what does not.

The Validate class is a wrapper for these filters: [http://www.php.net/manual/en/filter.filters.validate.php](http://www.php.net/manual/en/filter.filters.validate.php).

```php
<?php

// Outputs: boolean true
var_dump(SurfStack\Filtering\Validate::boolean('yes'));

// Outputs: boolean false
var_dump(SurfStack\Filtering\Validate::boolean('no', NULL, true));

// Outputs: null
var_dump(SurfStack\Filtering\Validate::boolean('random', NULL, true));

// Outputs: string 'jdoe@example.com' (length=16)
var_dump(SurfStack\Filtering\Validate::email('jdoe@example.com'));

// Outputs: boolean false
var_dump(SurfStack\Filtering\Validate::email('jdoe@example'));

// Outputs: null
var_dump(SurfStack\Filtering\Validate::email('jdoe@example', null));

// Outputs: float 100
var_dump(SurfStack\Filtering\Validate::float('100'));

// Outputs: float 10
var_dump(SurfStack\Filtering\Validate::float(10));

// Outputs: boolean false
var_dump(SurfStack\Filtering\Validate::float('abc'));

// Outputs: int 100
var_dump(SurfStack\Filtering\Validate::int('100'));

// Outputs: boolean false
var_dump(SurfStack\Filtering\Validate::int('100.5'));

// Outputs: string '8.8.8.8' (length=7)
var_dump(SurfStack\Filtering\Validate::ip('8.8.8.8'));

// Outputs: boolean false
var_dump(SurfStack\Filtering\Validate::ip('8.8.8'));

// Outputs: string 'FE80::0202:B3FF:FE1E:8329' (length=25)
var_dump(SurfStack\Filtering\Validate::ip('FE80::0202:B3FF:FE1E:8329'));

// Outputs: string 'Abc123' (length=6)
var_dump(SurfStack\Filtering\Validate::regexp('Abc123', '@^/?([a-zA-Z0-9_]+)/?$@'));

// Outputs: boolean false
var_dump(SurfStack\Filtering\Validate::regexp('Abc123.', '@^/?([a-zA-Z0-9_]+)/?$@'));

// Outputs: string 'http://example.com' (length=18)
var_dump(SurfStack\Filtering\Validate::url('http://example.com'));

// Outputs: string 'http://example.com' (length=18)
var_dump(SurfStack\Filtering\Validate::url('http://example.com'));

// Outputs: boolean false
var_dump(SurfStack\Filtering\Validate::url('example.com'));

```