<?php

/**
 * This file is part of the SurfStack package.
 *
 * @package SurfStack
 * @copyright Copyright (C) Joseph Spurrier. All rights reserved.
 * @author Joseph Spurrier (http://josephspurrier.com)
 * @license http://www.apache.org/licenses/LICENSE-2.0.html
 */

use SurfStack\Filtering\Validate;

/**
 * Validate Test
 * 
 * Ensures the validate methods work properly
 *
 */
class ValidateTest extends PHPUnit_Framework_TestCase
{
    public function testBoolean()
    {
        $this->assertTrue(Validate::boolean(true));
        $this->assertTrue(Validate::boolean(' true '));
        $this->assertTrue(Validate::boolean(' 1 '));
        $this->assertTrue(Validate::boolean(' ON '));
        $this->assertTrue(Validate::boolean(' YES '));
        $this->assertFalse(Validate::boolean('a'));
        $this->assertFalse(Validate::boolean('false'));
        $this->assertFalse(Validate::boolean(''));
        $this->assertFalse(Validate::boolean('   '));
        $this->assertFalse(Validate::boolean(NULL));
        $this->assertFalse(Validate::boolean('false', null, true));
        $this->assertNull(Validate::boolean('falsef', null, true));
        $this->assertFalse(Validate::boolean('false', false, true));
        $this->assertFalse(Validate::boolean('false', false, true));
        $this->assertSame(Validate::boolean(' false ', 'asdf', true), false);
        $this->assertSame(Validate::boolean('abcde', 'asdf', true), 'asdf');
        $this->assertSame(Validate::boolean('false', 'asdf', false), 'asdf');
        $this->assertSame(Validate::boolean('abcde', 'asdf', false), 'asdf');
    }
    
    public function testEmail()
    {
        $email = 'jdoe@example.com';
        $this->assertSame(Validate::email($email), $email);
        $email = 'jdoe@example.com.com';
        $this->assertSame(Validate::email($email), $email);
        $email = 'jdoe@example.co';
        $this->assertSame(Validate::email($email), $email);
        $email = 'jdoe@example.c';
        $this->assertSame(Validate::email($email), $email);
        $email = 'jdoe@example.';
        $this->assertSame(Validate::email($email), false);
        $email = 'jdoe@example';
        $this->assertSame(Validate::email($email), false);
        $email = 'jdoe@example..';
        $this->assertSame(Validate::email($email), false);
        $email = 'jdoe@e.c';
        $this->assertSame(Validate::email($email), $email);
        $email = 'a@b.c';
        $this->assertSame(Validate::email($email), $email);
        $email = 'a@b.c.';
        $this->assertSame(Validate::email($email), false);
        $email = 'a@b.c.d';
        $this->assertSame(Validate::email($email), $email);
        $email = 'a@b.c.d.e.f.g.h.i.j.k.l';
        $this->assertSame(Validate::email($email), $email);
        $email = 'a@.c';
        $this->assertSame(Validate::email($email), false);
        $email = 'a.@.c';
        $this->assertSame(Validate::email($email), false);
        $email = '@b.c';
        $this->assertSame(Validate::email($email), false);
        $email = 'ab.c';
        $this->assertSame(Validate::email($email), false);
        $email = 'true';
        $this->assertSame(Validate::email($email), false);
        $email = true;
        $this->assertSame(Validate::email($email), false);
        $email = 'a+@b.c';
        $this->assertSame(Validate::email($email), $email);
        $email = 'a @b.c';
        $this->assertSame(Validate::email($email), false);
        $email = 'a@ b.c';
        $this->assertSame(Validate::email($email), false);
        $email = 'a@b.c ';
        $this->assertSame(Validate::email($email), trim($email));
        $email = ' a@b.c';
        $this->assertSame(Validate::email($email), trim($email));
        $email = ' a@b.c ';
        $this->assertSame(Validate::email($email, 'NA'), trim($email));
        $email = ' a@b.c ';
        $this->assertSame(Validate::email($email, 'NA', false), 'NA');
    }
    
    public function testFloat()
    {
        $float = 1;
        $this->assertSame(Validate::float($float), 1.0);
        $float = 1.0;
        $this->assertSame(Validate::float($float), $float);
        $float = ' 1000.0 ';
        $this->assertSame(Validate::float($float, false, false), 1000.0);
        $float = '1,000.0';
        $this->assertSame(Validate::float($float, false, false), false);
        $float = '1,000.0';
        $this->assertSame(Validate::float($float, false, false, true), 1000.0);
        $float = ' 1,00 ';
        $this->assertSame(Validate::float($float, null, false, true), null);
        $float = '100';
        $this->assertSame(Validate::float($float, null, false, true), 100.0);
        $float = '100.000000';
        $this->assertSame(Validate::float($float, null, 5, true), 100.0);
        $float = '100.0.0';
        $this->assertSame(Validate::float($float, null, 5, true), NULL);
        $float = '100,00';
        $this->assertSame(Validate::float($float, null, ',', true), 100.0);
    }
    
    public function testInt()
    {
        $int = 123;
        $this->assertSame(Validate::int($int), $int);
        $int = PHP_INT_MAX;
        $this->assertSame(Validate::int($int), $int);
        $int = PHP_INT_MAX+1;
        $this->assertSame(Validate::int($int), false);
        $int = 'abc';
        $this->assertSame(Validate::int($int, null), null);
        $int = 123;
        $this->assertSame(Validate::int($int, null), $int);
        $int = 4;
        $this->assertSame(Validate::int($int, false, 5), false);
        $int = 4.9999999;
        $this->assertSame(Validate::int($int, false, 5), false);
        $int = 5;
        $this->assertSame(Validate::int($int, false, 5), $int);
        $int = '5';
        $this->assertSame(Validate::int($int, false, 5), 5);
        $int = 6;
        $this->assertSame(Validate::int($int, false, 5, 6), $int);
        $int = 7;
        $this->assertSame(Validate::int($int, false, 5, 6), false);        
        $int = ' 0xf0 ';
        $this->assertSame(Validate::int($int), false);
        $int = '0xf0';
        $this->assertSame(Validate::int($int, false, false, false, true), 240);
        $int = 0xf0;
        $this->assertSame(Validate::int($int, false, false, false, true), 240);
        $int = '0755';
        $this->assertSame(Validate::int($int, false, false, false, false, true), 493);
        $int = 0755;
        $this->assertSame(Validate::int($int, false, false, false, false, true), 493);
        $int = '0755';
        $this->assertSame(Validate::int($int, false, false, false, false, false), false);
        $int = ' 0755 ';
        $this->assertSame(Validate::int($int, false, false, false, false, false), false);
        $int = 0755;
        $this->assertSame(Validate::int($int, false, false, false, false, false), 493);
        $int = ' 0755 ';
        $this->assertSame(Validate::int($int, false, false, false, false, true), 493);
    }
    
    public function testIP()
    {
        $ip = '127.0.0.1';
        $this->assertSame(Validate::ip($ip), $ip);
        $ip = '0';
        $this->assertSame(Validate::ip($ip), false);
        $ip = '0.0';
        $this->assertSame(Validate::ip($ip), false);
        $ip = '0.0.0';
        $this->assertSame(Validate::ip($ip), false);
        $ip = '0.0.0.';
        $this->assertSame(Validate::ip($ip), false);
        $ip = '0.0.0.0';
        $this->assertSame(Validate::ip($ip), $ip);
        $ip = '0.0.0.0.';
        $this->assertSame(Validate::ip($ip), false);
        $ip = '0.0.0.0.0';
        $this->assertSame(Validate::ip($ip), false);
        $ip = '0,0,0,0';
        $this->assertSame(Validate::ip($ip), false);
        $ip = '255.255.255.255';
        $this->assertSame(Validate::ip($ip), $ip);
        $ip = ' 255.255.255.255 ';
        $this->assertSame(Validate::ip($ip, false, false), false);
        $ip = ' 255.255.255.255 ';
        $this->assertSame(Validate::ip($ip), trim($ip));
        $ip = '255.255.255.256';
        $this->assertSame(Validate::ip($ip), false);
        $ip = '255.255.255.256';
        $this->assertSame(Validate::ip($ip, null), null);
        $ip = '255.255.255. 255';
        $this->assertSame(Validate::ip($ip), false);
        $ip = '0000:0000:0000:0000:0000:0000:0000:0000';
        $this->assertSame(Validate::ip($ip), $ip);
        $ip = 'FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF';
        $this->assertSame(Validate::ip($ip), $ip);
        $ip = 'GGGG:GGGG:GGGG:GGGG:GGGG:GGGG:GGGG:GGGG';
        $this->assertSame(Validate::ip($ip), false);
        $ip = 'FE80:0000:0000:0000:0202:B3FF:FE1E:8329';
        $this->assertSame(Validate::ip($ip), $ip);
        $ip = 'FE80::0202:B3FF:FE1E:8329';
        $this->assertSame(Validate::ip($ip), $ip);
        $ip = '0000:0000:0000:0000:0000:0000:0000:0000';
        $this->assertSame(Validate::ip($ip, false, true, true), false);
        $ip = '0000:0000:0000:0000:0000:0000:0000:0000';
        $this->assertSame(Validate::ip($ip, false, true, false, true), $ip);
        $ip = '127.0.0.1';
        $this->assertSame(Validate::ip($ip, false, true, true ), '127.0.0.1');
        $ip = '127.0.0.1';
        $this->assertSame(Validate::ip($ip, false, true, false, false, true), '127.0.0.1');
        $ip = '10.0.0.0';
        $this->assertSame(Validate::ip($ip, false, true, false, false, true), false);
        $ip = '172.16.0.0';
        $this->assertSame(Validate::ip($ip, false, true, false, false, true), false);
        $ip = '192.168.0.0';
        $this->assertSame(Validate::ip($ip, false, true, false, false, true), false);
        $ip = '192.167.0.0';
        $this->assertSame(Validate::ip($ip, false, true, false, false, true), $ip);
        $ip = '127.0.0.1';
        $this->assertSame(Validate::ip($ip, false, true, false, false, true, true), false);
        $ip = '127.0.0.2';
        $this->assertSame(Validate::ip($ip, false, true, false, false, true, true), $ip);
        $ip = '000.000.000.000';
        $this->assertSame(Validate::ip($ip), false);
        $ip = 'a.0.0.0';
        $this->assertSame(Validate::ip($ip), false);
        $ip = '2001:db8::1';
        $this->assertSame(Validate::ip($ip), $ip);
        
    }

    public function testRegexp()
    {
        $pattern = '([a-zA-Z0-9_]+)';
        $reg = '@^/?'.$pattern.'/?$@';
        
        $val = 'Abc123';
        $this->assertSame(Validate::regexp($val, $reg), $val);
        $val = '';
        $this->assertSame(Validate::regexp($val, $reg), false);
        $val = ' ';
        $this->assertSame(Validate::regexp($val, $reg), false);
        $val = 'a';
        $this->assertSame(Validate::regexp($val, $reg), $val);
        $val = 'a?';
        $this->assertSame(Validate::regexp($val, $reg), false);
        $val = 'asldkfjlksugklsSDFKLJLusu8gjoi4otjp8e4tg';
        $this->assertSame(Validate::regexp($val, $reg), $val);
        $val = 'a?';
        $this->assertSame(Validate::regexp($val, $reg, null), null);
        $val = ' a ';
        $this->assertSame(Validate::regexp($val, $reg, false), trim($val));
        $val = ' a ';
        $this->assertSame(Validate::regexp($val, $reg, false, false), false);
    }
    
    public function testURL()
    {
        $url = 'example.com';
        $this->assertSame(Validate::url($url), false);
        $url = 'www.example.com';
        $this->assertSame(Validate::url($url), false);
        $url = '//example.com';
        $this->assertSame(Validate::url($url), false);
        $url = 'http:example.com';
        $this->assertSame(Validate::url($url), false);
        $url = 'http://example.com';
        $this->assertSame(Validate::url($url), $url);
        $url = 'http://www.example.com';
        $this->assertSame(Validate::url($url), $url);
        $url = 'https://www.example.com';
        $this->assertSame(Validate::url($url), $url);
        $url = 'ftp://www.example.com';
        $this->assertSame(Validate::url($url), $url);
        $url = 'a://';
        $this->assertSame(Validate::url($url), false);
        $url = 'a://b';
        $this->assertSame(Validate::url($url), $url);
        $url = 'a://b.c';
        $this->assertSame(Validate::url($url), $url);
        $url = 'a://b.c.d';
        $this->assertSame(Validate::url($url), $url);
        $url = 'a://b.c.d/e';
        $this->assertSame(Validate::url($url), $url);
        $url = 'a://b.c.d/e/g/h/i/j/k/l/n/m/o/p';
        $this->assertSame(Validate::url($url), $url);
        $url = 'a://b.c.d/e/g/h/i/j/k/l/n/m/o/p/';
        $this->assertSame(Validate::url($url), $url);
        $url = 'a://b.c.d/;/?:@&=+$,-_.!~*\'()%<>#"`^[]{}|';
        $this->assertSame(Validate::url($url), $url);
        $url = 'a://.';
        $this->assertSame(Validate::url($url), $url);
        $url = 'a://';
        $this->assertSame(Validate::url($url, null), null);
        $url = ' a://b.c.d ';
        $this->assertSame(Validate::url($url, false, true), trim($url));
        $url = ' a://b.c.d ';
        $this->assertSame(Validate::url($url, false, false), false);
        $url = 'a://b.c.d';
        $this->assertSame(Validate::url($url, false, false, true), false);
        $url = 'a://b.c.d/test';
        $this->assertSame(Validate::url($url, false, false, true), $url);
        $url = 'a://b.c.d/test';
        $this->assertSame(Validate::url($url, false, false, true, true), false);
        $url = 'a://b.c.d/test?test';
        $this->assertSame(Validate::url($url, false, false, true, true), $url);
    }
}