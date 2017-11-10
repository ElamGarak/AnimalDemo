<?php
/**
 * Created using PhpStorm.
 * Author: Josh Pacheco <joshua.pacheco@gmail.com>
 * Project: AnimalDemo
 * Date: 3/27/2016
 */

namespace api\Enums;

/**
 * These are the string values of the params used to access the AnimalList endpoint.  These are placed in constants to
 * cut down on the usage of magic strings and can be utilized when running unit tests
 * Class AnimalList
 *
 * @package api\Enums
 */
class AnimalList {

    const LIMIT = 'limit';
    const OFFSET = 'offset';
}