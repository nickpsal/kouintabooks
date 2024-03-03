<?php
    session_start();
    /** required files **/
    require "../vendor/autoload.php";
    /**error display */
    DEBUG ? ini_set("display_errors", 1) : ini_set("display_errors", 0);
    /** load app class **/
    $app = new App;