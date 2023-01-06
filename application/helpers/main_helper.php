<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if( !function_exists('strShortner'))
{
    function strShortner($str, $amount)
    {
        return (strlen($str) > $amount) ? substr($str, 0, $amount) : $str;
    }
}

if ( ! function_exists('setActiveClass'))
{
    function setActiveClass($linkName)
    {
        $lastUrlLink = (explode('/', $_SERVER['REQUEST_URI'])[count(explode('/', $_SERVER['REQUEST_URI']))- 1] === '') ? 'home' : explode('/', $_SERVER['REQUEST_URI'])[count(explode('/', $_SERVER['REQUEST_URI']))- 1]; 

        return ($lastUrlLink === $linkName) ? 'active' : '';
    }   
}
