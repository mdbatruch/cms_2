<?php 
    
    //output buffering is turned on
    ob_start();

    //turn on sessions
    session_start();

    date_default_timezone_set('America/Toronto');

    // __FILE__ returns the current path to this file
    // dirname() returns the path to the parent directory
    
    //find the current file's directory
    define("PRIVATE_PATH", dirname(__FILE__));
    //find the directory of the directory of the current file
    define("PROJECT_PATH", dirname(PRIVATE_PATH));
    define("PUBLIC_PATH", PROJECT_PATH . '/public');
    define("SHARED_PATH", PRIVATE_PATH . '/shared');

    // Assign the root URL to a PHP constant
    // * Do not need to include the domain
    // * Use same document root as webserver
    // * Can set a hardcoded value:
    // define("WWW_ROOT", '');
    // * Can dynamically find everything in URL up to "/public"
    $public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
    $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
    define("WWW_ROOT", $doc_root);

    require_once('functions.php');
    require_once('database.php');
    require_once('query_functions.php');
    require_once('validation_functions.php');
    require_once('auth_functions.php');

    $db = db_connect();
    $errors = [];
?>
