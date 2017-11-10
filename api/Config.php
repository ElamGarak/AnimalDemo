<?php
/**
 * Created using PhpStorm.
 * Author: Josh Pacheco <joshua.pacheco@gmail.com>
 * Project: AnimalDemo
 * Date: 3/26/2016
 */

namespace api;

require('autoloader.php'); // Require autoloader here since config file will be called at the controller level where all classes are instantiated

/**
 * 'Global' class which pulls core config values from ini file located outside of web directory
 *
 * Class Config
 * @package api
 */
class Config {

    /** @var mixed[]  */
    private static $config = [];

    /**
     * Static method that pulls core values from ini file and sets them internally in an array
     * @return mixed[]
     */
    public static function get() {
        $settings = file('../../../conf/settings.ini'); // TODO, this should be in a lazy getter or perhaps stored on the session

        // TODO error handling should be done here to ensure config file is formatted as expected here
        foreach ($settings as $line) {
            list($key, $value) = explode('=', $line);

            self::$config[$key] = trim($value);
        }

        return self::$config;
    }
}