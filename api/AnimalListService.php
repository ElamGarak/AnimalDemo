<?php
/**
 * Created using PhpStorm.
 * Author: Josh Pacheco <joshua.pacheco@gmail.com>
 * Project: AnimalDemo
 * Date: 3/26/2016
 */

namespace api;

use stdClass;

/**
 * Service that is used to return animal list from the dao.  Any extra business logic can be done at this layer
 *
 * Class AnimalListService
 * @package api
 */
class AnimalListService {
    
    /** @var AnimalListDao  */
    private $dao = null;
    
    public function __construct(AnimalListDao $dao) {
        $this->dao = $dao;
    }

    /**
     * Method used to pull 'get' list data from dao
     * @param array $params
     * @return stdClass[]
     */
    public function get(array $params = []) {
        // TODO validation needs to occur here
        return $this->dao->getList($params);
    }

    /**
     * Method used to pull 'get' count of all records from dao
     *
     * @return stdClass[]
     */
    public function getCount() {
        return $this->dao->getListCount();
    }
}