<?php


namespace Edv\Orm;


class Helper
{

    public static function unCamelize($camelCaps, $separator = '_'){
        return strtolower(preg_replace('/([a-z])([A-Z])/',"$1".$separator."$2",$camelCaps));
    }


}