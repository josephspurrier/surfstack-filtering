<?php

/**
 * This file is part of the SurfStack package.
 *
 * @package SurfStack
 * @copyright Copyright (C) Joseph Spurrier. All rights reserved.
 * @author Joseph Spurrier (http://josephspurrier.com)
 * @license http://www.apache.org/licenses/LICENSE-2.0.html
 */

namespace SurfStack\Filtering;

/**
 * Validate
 *
 * Check if the data meets certain qualifications.
 */
class Validate
{
    /**
     * Returns TRUE for "1", "true", "on" and "yes". Returns FALSE otherwise.
     * If FILTER_NULL_ON_FAILURE is set, FALSE is returned only for "0", "false", "off", "no", and "", and NULL is returned for all non-boolean values.
     * Automatically trims whitespace.
     * 
     * @link http://www.php.net/manual/en/filter.filters.validate.php
     * 
     * @param mixed $val
     * @param mixed $default
     * @param bool $blReturnDefaultOnFailure
     * 
     * @return mixed
     */
    static function boolean($val, $default = false, $blReturnDefaultOnFailure = false)
    {
        $options = array(
            'options' => array(
                'default' => $default,
            ),
            'flags' => ($blReturnDefaultOnFailure ? FILTER_NULL_ON_FAILURE : NULL),
        );

        return filter_var($val, FILTER_VALIDATE_BOOLEAN, $options);
    }
    
    /**
     * Validates value as e-mail. Returns FALSE otherwise.
     * Automatically trims whitespace (not native to filter_var).
     * 
     * @link http://www.php.net/manual/en/filter.filters.validate.php
     * 
     * @param mixed $val
     * @param mixed $default
     * @param boolean $trim
     * @return mixed
     */
    static function email($val, $default = false, $blTrim = true)
    {
        $options = array(
            'options' => array(
                'default' => $default,
            ),
        );
        
        return filter_var(($blTrim ? trim($val) : $val), FILTER_VALIDATE_EMAIL, $options);
    }
    
    /**
     * Validates value as float. Returns FALSE otherwise.
     * Automatically trims whitespace.
     * 
     * @link http://www.php.net/manual/en/filter.filters.validate.php
     * 
     * @param mixed $val
     * @param mixed $default
     * @param string $decimal
     * @param boolean $blAllowCommas
     * @return mixed
     */
    static function float($val, $default = false, $decimal = '.', $blAllowCommas = false)
    {
        $options = array(
            'options' => array(
                'default' => $default,
                'decimal' => $decimal,
            ),
            'flags' => ($blAllowCommas ? FILTER_FLAG_ALLOW_THOUSAND : false),
        );
    
        return filter_var($val, FILTER_VALIDATE_FLOAT, $options);
    }
    
    /**
     * Validates value as integer, optionally from the specified range.
     * Automatically trims whitespace.
     * 
     * @link http://www.php.net/manual/en/filter.filters.validate.php
     * 
     * @param mixed $val
     * @param mixed $default
     * @param int $min_range
     * @param int $max_range
     * @param boolean $blAllowHex
     * @param boolean $blAllowOctal
     * @return mixed
     */
    static function int($val, $default = false, $min_range = false, $max_range = false, $blAllowHex = false, $blAllowOctal = false)
    {        
        $options = array(
            'options' => array(
                'default' => $default,
                'min_range' => $min_range,
                'max_range' => ($max_range === false ? PHP_INT_MAX : $max_range),
            ),
            'flags' => ($blAllowHex ? FILTER_FLAG_ALLOW_HEX : false) | ($blAllowOctal ? FILTER_FLAG_ALLOW_OCTAL : false),            
        );
        
        return filter_var($val, FILTER_VALIDATE_INT, $options);
    }
    
    /**
     * Validates value as IP address, optionally only IPv4 or IPv6 or not from private or reserved ranges.
     * Automatically trims whitespace (not native to filter_var).
     * 
     * @link http://www.php.net/manual/en/filter.filters.validate.php
     * 
     * @param mixed $val
     * @param mixed $default
     * @param boolean $blTrim
     * @param boolean $blOnlyIPv4
     * @param boolean $blOnlyIPv6
     * @param boolean $blNoPrivate
     * @param boolean $blNoReserved
     * @return mixed
     */
    static function ip($val, $default = false, $blTrim = true, $blOnlyIPv4 = false, $blOnlyIPv6 = false, $blNoPrivate = false, $blNoReserved = false)
    {
        $options = array(
            'options' => array(
                'default' => $default,
            ),
            'flags' => ($blOnlyIPv4 ? FILTER_FLAG_IPV4 : false)
                | ($blOnlyIPv6 ? FILTER_FLAG_IPV6 : false)
                | ($blNoPrivate ? FILTER_FLAG_NO_PRIV_RANGE : false)
                | ($blNoReserved ? FILTER_FLAG_NO_RES_RANGE : false),
        );
    
        return filter_var(($blTrim ? trim($val) : $val), FILTER_VALIDATE_IP, $options);
    }
    
    /**
     * Validates value against regexp, a Perl-compatible regular expression.
     * Automatically trims whitespace (not native to filter_var).
     * 
     * @link http://www.php.net/manual/en/filter.filters.validate.php
     * 
     * @param mixed $val
     * @param string $regex
     * @param string $default
     * @param boolean $blTrim
     * @return mixed
     */
    static function regexp($val, $regex, $default = false, $blTrim = true)
    {
        $options = array(
            'options' => array(
                'default' => $default,
                'regexp' => $regex,
            ),
        );
    
        return filter_var(($blTrim ? trim($val) : $val), FILTER_VALIDATE_REGEXP, $options);
    }

    /**
     * Validates value as URL (according to » http://www.faqs.org/rfcs/rfc2396),
     * optionally with required components. Beware a valid URL may not specify
     * the HTTP protocol http:// so further validation may be required to
     * determine the URL uses an expected protocol, e.g. ssh:// or mailto:. Note
     * that the function will only find ASCII URLs to be valid; internationalized
     * domain names (containing non-ASCII characters) will fail.
     * Automatically trims whitespace (not native to filter_var).
     *
     * @link http://www.php.net/manual/en/filter.filters.validate.php
     *
     * @param mixed $val
     * @param mixed $default
     * @param boolean $blTrim
     * @param boolean $blRequirePath
     * @param boolean $blRequireQuery
     * @return mixed
     */
    static function url($val, $default = false, $blTrim = true, $blRequirePath = false, $blRequireQuery = false)
    {
        $options = array(
            'options' => array(
                'default' => $default,
            ),
            'flags' => ($blRequirePath ? FILTER_FLAG_PATH_REQUIRED : false)
                | ($blRequireQuery ? FILTER_FLAG_QUERY_REQUIRED : false),
        );
    
        return filter_var(($blTrim ? trim($val) : $val), FILTER_VALIDATE_URL, $options);
    }
}