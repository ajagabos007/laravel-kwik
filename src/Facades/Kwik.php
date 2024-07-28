<?php

/**
 * @package Ajagabos\Kwik\Facades
 * @author Philip James Ajagabos <ajagabos007@gmail.com> 
 * @filesource
 */

namespace Ajagabos\Kwik\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @author Philip James Ajagabos <ajagabos007@gmail.com> 
 * 
 */
class Kwik extends Facade
{
    /**
     * Get the registered name of the component
     * @author Philip James Ajagabos <ajagabos007@gmail.com> 
     * 
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-kwik';
    }
}