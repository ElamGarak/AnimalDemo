<?php
/**
 * Created using PhpStorm.
 * Author: Josh Pacheco <joshua.pacheco@gmail.com>
 * Project: AnimalDemo
 * Date: 3/26/2016
 */

namespace api;

use InvalidArgumentException;
use stdClass;

/**
 * Service that is used to return animal details from the dao.  Any extra business logic can be done at this layer
 *
 * Class AnimalListService
 * @package api
 */
class AnimalDetailsService {
    
    const ID = 'ID';
    
    /** @var AnimalDetailsDao  */
    private $dao = null;

    /**
     * Inject in Dao class here
     *
     * @param AnimalDetailsDao $dao
     */
    public function __construct(AnimalDetailsDao $dao) {
        $this->dao = $dao;
    }

    /**
     * This pulls 'get' the requested details from the dao
     *
     * NOTE For the purposes of this demo, we are simulating a restful architecture (Actual calls are done via GET)
     *
     * @param mixed[] $params
     * @return stdClass[]
     */
    public function get(array $params = []) {
        $this->validateGet($params); // TODO this belongs in its own validation class and invoked here via injection
        return $this->dao->getDetails($params[self::ID]);
    }

    /**
     * This pulls 'get' the lists of all drop downs used on the front end
     *
     * NOTE For the purposes of this demo, we are simulating a restful architecture (Actual calls are done via GET)
     *
     * @return array[]
     */
    public function getLists() {
        return $this->dao->getLists();
    }

    /**
     * This passes in updated data 'put' to the dao
     *
     * NOTE For the purposes of this demo, we are simulating a restful architecture (Actual calls are done via GET)
     *
     * @param mixed[] $params
     * @return stdClass[]
     */
    public function put(array $params = []) {
        // TODO this belongs in its own validation class and invoked here via injection
        // TODO this should call a method specific to put operations
        $this->validateGet($params);
        return $this->dao->updateDetails($params);
    }

    /**
     * This passes in new data 'post' to the day
     *
     * NOTE For the purposes of this demo, we are simulating a restful architecture (Actual calls are done via GET)
     *
     * @param mixed[] $params
     * @return stdClass[]
     */
    public function post(array $params = []) {
        // TODO validation needs to occur here
        return $this->dao->addRecord($params);
    }

    /**
     * Method used to remove 'delete' a record
     * NOTE For the purposes of this demo, we are simulating a restful architecture (Actual calls are done via GET)
     *
     * @param mixed[] $params
     * @return stdClass[]
     */
    public function delete(array $params = []) {
        // TODO this belongs in its own validation class and invoked here via injection
        // TODO this should call a method specific to delete operations
        $this->validateGet($params);
        return $this->dao->deleteRecord($params[self::ID]);
    }

    /**
     * Method used to validate incoming data passed via get.
     *
     * @param mixed[] $params
     * @throws InvalidArgumentException
     * TODO This could be made much more dynamic by using validator concretes
     */
    private function validateGet(array $params = []) {
        if (count($params)) { // Ensure there are even params
            if (array_key_exists(self::ID, $params)) { // Ensure specific param exists
                if (!is_numeric($params[self::ID])) { // Ensure value of specific param is numeric
                    throw new InvalidArgumentException(self::ID . " must be a number", 500);
                }
            } else {
                throw new InvalidArgumentException(self::ID . " key is missing from parameters", 500);
            }
        } else {
            throw new InvalidArgumentException("No " . self::ID . " was passed to service", 500);
        }
    }
}