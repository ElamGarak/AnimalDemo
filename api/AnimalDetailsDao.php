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
 * Dao that is used to collect animal details from the database
 *
 * Class AnimalDetailsDao
 * @package api\libraries
 * // TODO Move constants into a separate ENUM class
 */
class AnimalDetailsDao extends Database {

    const ANIMAL_LIST = "SELECT `ID`, Label
                         FROM `TABLE`";

    const ANIMAL_DETAILS = "SELECT
                          A.ID,
                          A.Name,
                          P.Label AS Phylum,
                          C.Label AS Class,
                          O.Label AS `Order`,
                          F.Label AS Family,
                          G.Label AS Genus,
                          S.Label AS Species,
                          A.Description
                         FROM Animals AS A
                         INNER JOIN Phylums AS P ON P.PhylumID = A.PhylumID
                         INNER JOIN Classes AS C ON C.ClassID = A.ClassID
                         INNER JOIN Orders AS O ON O.OrderID = A.OrderID
                         INNER JOIN Families AS F ON F.FamilyID = A.FamilyID
                         INNER JOIN Genuses AS G ON G.GenusID = A.GenusID
                         INNER JOIN Species AS S ON S.SpeciesID = A.SpeciesID
                         WHERE A.ID = ?";

    const UPDATE_DETAIL = "UPDATE Animals
                           SET Description = ?,
                               ClassID = ?,
                               FamilyID = ?,
                               GenusID = ?,
                               OrderID = ?,
                               PhylumID = ?,
                               SpeciesID = ?
                           WHERE ID = ?";

    const ADD_DETAIL = "INSERT INTO Animals (
                         `Name`,
                         Description,
                         ClassID,
                         FamilyID,
                         GenusID,
                         OrderID,
                         PhylumID,
                         SpeciesID
                        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                       ";

    const DELETE_RECORD = "DELETE FROM Animals
                           WHERE ID = ?";

    /**
     * This is used for collecting the major details.  Each lookup table is keyed in for dynamic looping
     * @var array[]
     * // TODO A better approach may be to use a stored proceedur that returns all of this in one hit
     */
    private static $lists = [
        'Class' => [
            'Classes',
            'ClassID'
        ],
        'Family' => [
            'Families',
            'FamilyID'
        ],
        'Genus' => [
            'Genuses',
            'GenusID'
        ],
        'Order' => [
            'Orders',
            'OrderID'
        ],
        'Phylum' => [
            'Phylums',
            'PhylumID'
        ],
        'Species' => [
            'Species',
            'SpeciesID'
        ],
    ];

    /**
     * Dynamily pull all data out of lookup tables and return as a list of data
     * @return array[]
     */
    public function getLists() {
        $lists = [];
        foreach (self::$lists as $key => $value) {
            $sql = str_replace("`TABLE`", $value[0], self::ANIMAL_LIST);
            $sql = str_replace("`ID`", $value[1], $sql);
            $lists[$key] = $this->select($sql);
        }

        return $lists;
    }

    /**
     * Used to pull detials of a particular record based on incoming id
     *
     * @param int $id
     * @return stdClass[]
     * @throws RuntimeException
     * TODO Even though this is meant to be invoked after data validation has occurred in the service it may be wise to do so again since this method is public
     */
    public function getDetails($id) {
        try {
            $result = $this->selectWithParams(self::ANIMAL_DETAILS, [$id]);

            if (count($result)) {
                return $result[0];
            }

            return [];
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Method used to update 'put' details for a record
     *
     * @param mixed[] $incomingParams
     * @return bool[]
     * @throws RuntimeException
     * TODO Even though this is meant to be invoked after data validation has occurred in the service it may be wise to do so again since this method is public
     */
    public function updateDetails(array $incomingParams = []) {
        try {
            // TODO This belongs in a marshaller and the keys should be constants and not magic strings
            $params = [
                $incomingParams['Description'],
                (int) $incomingParams['Class'],
                (int) $incomingParams['Family'],
                (int) $incomingParams['Genus'],
                (int) $incomingParams['Order'],
                (int) $incomingParams['Phylum'],
                (int) $incomingParams['Species'],
                (int) $incomingParams['ID'],
            ];

            $this->query(self::UPDATE_DETAIL, array_values($params));

            return ['success' => true];
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Method used to add 'post' a new record into the database
     *
     * @param mixed[] $incomingParams
     * @return bool[]
     * @throws RuntimeException
     * TODO Even though this is meant to be invoked after data validation has occurred in the service it may be wise to do so again since this method is public
     */
    public function addRecord(array $incomingParams = []) {
        try {
            //** START Code Duplication **// TODO This block of code is reused elsewhere in the class, it should be abstracted
            $params = [];
            foreach ($incomingParams as $value) {
                // TODO make type casting more dynamic here
                $params[] = (is_numeric($value)) ? (int) $value : (string) urldecode($value); // Since this is a demo we will assume only full integers or strings
            }
            //** END Code Duplication **//

            $this->query(self::ADD_DETAIL, $params);

            return ['success' => true];
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Method used to remove 'delete' record based on id
     *
     * @param int $id
     * @return bool[]
     * TODO Even though this is meant to be invoked after data validation has occurred in the service it may be wise to do so again since this method is public
     */
    public function deleteRecord($id) {
        try {
            // TODO once the above code is abstracted, we could make use of that code here for data casting
            $this->query(self::DELETE_RECORD, [ (int) $id ]);

            return ['success' => true];
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode());
        }
    }
}