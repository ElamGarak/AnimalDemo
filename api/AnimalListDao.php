<?php
/**
 * Created using PhpStorm.
 * Author: Josh Pacheco <joshua.pacheco@gmail.com>
 * Project: AnimalDemo
 * Date: 3/26/2016
 */

namespace api;

use api\libraries\Database;
use Exception;
use RuntimeException;
use stdClass;

/**
 * Dao that is used to collect animal list from the database
 *
 * Class AnimalListDao
 * @package api
 * // TODO Move constants into a separate ENUM class
 */
class AnimalListDao extends Database {

    // Default values if no params are passed
    const LIMIT = 3;
    const OFFSET = 0;

    const ANIMAL_LIST = "SELECT
                          A.ID,
                          A.Name, 
                          S.Label AS Species 
                         FROM Animals AS A 
                         INNER JOIN Species AS S ON S.SpeciesID = A.SpeciesID
                         LIMIT ?, ?";

    const ANIMAL_LIST_COUNT = "SELECT
                                COUNT(A.ID) AS Total
                                FROM Animals AS A
                                INNER JOIN Species AS S ON S.SpeciesID = A.SpeciesID";


    /**
     * Method used to pull back 'get' the list of records
     * @param mixed[] $incomingParams
     * @return stdClass[]
     * @throws RuntimeException
     */
    public function getList(array $incomingParams = []) {
        try {
            // TODO this is ugly, it can probably be made cleaner and at best, placed in its own method
            $params = [];
            if (empty($incomingParams)) {
                $params = [
                    self::OFFSET,
                    self::LIMIT,
                ];
            } else {
                foreach ($incomingParams as $value) {
                    $params[] = (int) $value;
                }
            }

            return $this->selectWithParams(self::ANIMAL_LIST, $params);
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Method used to pull back 'get' count of all records in the database
     *
     * @return stdClass[]
     */
    public function getListCount() {
        try {
            return $this->select(self::ANIMAL_LIST_COUNT);
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode());
        }
    }
}