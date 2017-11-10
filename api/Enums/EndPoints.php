<?php
/**
 * Created using PhpStorm.
 * Author: Josh Pacheco <joshua.pacheco@gmail.com>
 * Project: AnimalDemo
 * Date: 3/27/2016
 */

namespace api\Enums;

/**
 * These are the string values of the endpoints used in the api.  These are placed in constants to cut down on the usage
 * of magic strings and can be utilized when running unit tests
 *
 * Class Endpoints
 * @package api\Enums
 */
class Endpoints {

    const ANIMAL_LIST = 'list';
    const ANIMAL_LIST_COUNT = 'count';
    const ANIMAL_DETAILS = 'details';
    const UPDATE = 'update';
    const ADD = 'add';
    const DELETE = 'delete';
    const LISTS = 'lists';
}