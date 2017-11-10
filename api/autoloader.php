<?php
/**
 * Created using PhpStorm.
 * Author: Josh Pacheco <joshua.pacheco@gmail.com>
 * Project: AnimalDemo
 * Date: 3/26/2016
 */

/**
 * Native PHP function implimentation that allows api to instatiate a class witout having to use 'require' for every
 * occurrence in files
 *
 * @param string $className
 */
function __autoload($className = "") {
    // Construct path based on environment and 'prepare' it for checking
    $path = str_replace('/api', '', __DIR__) . '/' . str_replace('\\', '/', $className) . '.php';

    // Check if class file exists
    if (is_file($path)) {
        /** @noinspection PhpIncludeInspection */
        require_once($path); // Set definition of class
    } else {
        // Class file does not exist, kill everything
        die("[$path] does not exist on server.  Check your class name or namespace");
    }
}
