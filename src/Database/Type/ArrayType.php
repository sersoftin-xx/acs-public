<?php
/**
 * Created by PhpStorm.
 * User: Sergo
 * Date: 10.05.2016
 * Time: 13:37
 */

namespace App\Database\Type;

use Cake\Database\Driver;
use Cake\Database\Type;
use PDO;

class ArrayType extends Type
{

    public function toPHP($value, Driver $driver)
    {
        if ($value === null) {
            return null;
        }
        return explode(';', $value);
    }

    public function marshal($value)
    {
        if (is_array($value) || $value === null) {
            return $value;
        }
        return explode(';', $value);
    }

    public function toDatabase($value, Driver $driver)
    {
        return implode(';', $value);
    }

    public function toStatement($value, Driver $driver)
    {
        if ($value === null) {
            return PDO::PARAM_NULL;
        }
        return PDO::PARAM_STR;
    }

}