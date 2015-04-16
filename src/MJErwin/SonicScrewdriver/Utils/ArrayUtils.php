<?php


namespace MJErwin\SonicScrewdriver\Utils;


/**
 * @author Matthew Erwin <matthew.j.erwin@me.com>
 * www.matthewerwin.co.uk
 */
class ArrayUtils extends \Zend\Stdlib\ArrayUtils
{
    /**
     * @param $array
     * @param $key_name
     */
    public static function sortByArrayKey(&$array, $key_name)
    {
        usort($array, function ($a, $b) use ($key_name)
        {
            return $a[$key_name] - $b[$key_name];
        });
    }
} 