<?php
    function _autoload($class_name) {
        $dirname = dirname(dirname(__FILE__)) ;
        $path = "{$dirname}/lib/{$class_name}.php";
        require $path;
    }

spl_autoload_register("_autoload");
