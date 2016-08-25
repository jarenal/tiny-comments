<?php

class MyDebug {

    public static function log($object, $label)
    {
        if(DEBUG)
        {
            FB::log($object, $label);
        }
    }
}