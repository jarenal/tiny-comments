<?php
session_start();

/* DATABASE CONNECTION */
define("DB_HOST", "localhost");
define("DB_NAME", "");
define("DB_USER", "");
define("DB_PASS", "");

/* TABLES NAMES */
define("TB_USERS", "users");
define("TB_MESSAGES", "messages");

/* DEBUG */
define("DEBUG", false);

/* CLASS LOADER */
spl_autoload_register(function($class){
    $path = dirname(__FILE__)."/../classes/$class.class.php";

    if(file_exists($path))
    {
        include $path;
    }
});
