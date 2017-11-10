<?php
/**
 * Created using PhpStorm.
 * Author: Josh Pacheco <joshua.pacheco@gmail.com>
 * Project: AnimalDemo
 * Date: 3/26/2016
 */

namespace api\libraries;

use Exception;
use RuntimeException;

/**
 * Core library class that handles Restful requests
 *
 * Class Request
 * @package api\libraries
 */
class Request {

    /** @var  string */
    protected $fileGetContents;

    /** mixed[] */
    private $parameters = [];

    /**
     * Upon invocation, pull out incoming data from native PHP super globals
     */
    public function __construct() {
        try {
            if (!array_key_exists('REQUEST_METHOD', $_SERVER)) {
                $_SERVER['REQUEST_METHOD'] = 'COMMAND_LINE';
            }

            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET' :
                    $this->parameters = $_GET;
                    break;
                case 'POST' :
                    $this->parameters = $_REQUEST; // TODO This needs to be swapped out with $this->decodePutAndPostRequests() (See bug in method declaration below
                    break;
                case 'PUT' :
                    $this->parameters = $this->decodePutAndPostRequests();
                    break;
                case 'DELETE' :
                    $this->parameters = $this->decodePutAndPostRequests();
                    break;
            }
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Getter that will pull back collected results
     * @return mixed
     */
    public function fetch() {
        return $this->parameters;
    }

    /**
     * // Method that takes data used in Restful calls and converts it into a data structure that can be used by the api
     *
     * @return mixed[]
     * @throws Exception
     * // TODO This method can not be used with anything less than PHP 5.5 (Current environment is 5.4)
     * // TODO Known bug when creating $rawString using large bulk text
     */
    private function decodePutAndPostRequests() {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'POST') {
            $rawString = $this->fileGetContents();
            $rawString = trim(preg_replace("/\n?\s+?\"/","\"", $rawString));

            $payload = (array) json_decode($rawString,true);

            switch (json_last_error()) {
                case JSON_ERROR_NONE :
                    if (array_key_exists(0, $payload)) {
                        $_REQUEST = array_merge($_REQUEST, ['collection' => $payload]);
                    } else {
                        $_REQUEST = array_merge($_REQUEST, $payload);
                    }
                    break;
                default :
                    // TODO json_last_error_msg() only works in PHP 5.5+
                    throw new Exception("You have entered malformed JSON: " . json_last_error_msg(), 500);
                    break;
            }
        } else {
            $_REQUEST = array_merge($_REQUEST, (array) json_decode($this->fileGetContents()));
        }

        return $_REQUEST;
    }
    /**
     * Lazy getter that pulls input derived from Restful cvall out of php://input file
     * @return string
     */
    private function fileGetContents() {
        if ($this->fileGetContents == null) {
            $this->fileGetContents = file_get_contents('php://input');
        }

        return $this->fileGetContents;
    }
}