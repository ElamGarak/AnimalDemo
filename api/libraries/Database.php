<?php
/**
 * Created using PhpStorm.
 * Author: Josh Pacheco <joshua.pacheco@gmail.com>
 * Project: AnimalDemo
 * Date: 3/26/2016
 */

namespace api\libraries;

use stdClass;

/**
 * Core library where all database interactions is handled.  This library is built using the PHP mysqli libraries that
 * can be referenced at: http://php.net/manual/en/book.mysqli.php
 *
 * Class Database
 * @package api\libraries
 *
 * TODO create a parent class that containes wrappers for all native methods so they can be mocked in unit testing
 * TODO add more methods to perform more complex database interactions as needed
 */
class Database {

    /** resource */
    private $db = null;

    /** @var mixed[]  */
    private $config = [];

    /**
     * When this class is invoked, an attempt is made to hit the database and if successful, the database handle is stored
     * internal to this class
     *
     * @param mixed[]
     *
     * @TODO This needs to have error handling put in place
     */
    public function __construct(array $config = []) {
        $this->config = $config;

        $this->db = mysqli_connect(ini_get("mysql.default_host"), $this->config['USER'], $this->config['PASSWORD'], $this->config['DATABASE']);
    }

    /**
     * Method allows for simple select without any parameters being passed
     *
     * @param $sql string
     * @return stdClass[]
     *
     * @TODO This needs to have error handling put in place
     */
    public function select($sql) {
        $results = [];
        // TODO Put a check in place to ensure this is only an SELECT statement
        if ($result = $this->db->query($sql)) {
            while($obj = $result->fetch_object()) {
                $results[] = $obj;
            }
        }

        return $results;
    }

    /**
     * Method allows for a select statement with parameters passed.  SQL must be set up a prepared statement and the
     * parameters then set using 'prepare'.
     *
     * @param string $sql
     * @param mixed[] $params
     * @return stdClass[]
     *
     * @TODO This needs to have error handling put in place
     */
    public function selectWithParams($sql, array $params = []) {
        $fields = [];
        $results = [];
        // TODO Put a check in place to ensure this is only an  SELECT statement
        if ($stmt = $this->db->prepare($sql)) {
            //** START Code Duplication **// TODO This block of code is reused elsewhere in the class, it should be abstracted
            if (!empty($params)) {
                $types = '';
                foreach ($params as $param) {
                    if (is_string($param)) {
                        $types .= 's';  // Strings
                    } else if (is_int($param)) {
                        $types .= 'i';  // Integers
                    } else if (is_float($param)) {
                        $types .= 'd';  // Doubles
                    } else {
                        $types .= 'b';  // Default for blobs and unknown types
                    }
                }

                $bind_names[] = $types;
                for ($i = 0; $i < count($params); $i++) {
                    $bind_name = 'bind' . $i;
                    $$bind_name = $params[$i];
                    $bind_names[] = &$$bind_name;
                }

                call_user_func_array(array($stmt, 'bind_param'), $bind_names);
            }
            //** END Code Duplication **//

            // Execute query
            $stmt->execute();
            // Get metadata for field names
            $meta = $stmt->result_metadata();
            // Create an array of variables to for binding the results
            while ($field = $meta->fetch_field()) {
                $var = $field->name;
                $$var = null;
                $fields[$var] =& $$var;
            }

            // Bind Results for fetching
            call_user_func_array(array($stmt, 'bind_result'), $fields);

            // Fetch Results
            $i = 0;
            while ($stmt->fetch()) {
                $results[$i] = [];
                $buffer = [];
                foreach ($fields as $k => $v) {
                    $buffer[$k] = $v;
                }
                $results[$i] = (object) $buffer;
                $i++;
            }
        }

        return $results;
    }

    /**
     * Generic query used for updates and deletes
     *
     * @param string $sql
     * @param mixed[] $params
     * @return stdClass[]
     *
     * @TODO This needs to have error handling put in place
     */
    public function query($sql, array $params = []) {
        // TODO Put a check in place to ensure this is only an UPDATE or DELETE statement
        if ($stmt = $this->db->prepare($sql)) {
            //** START Code Duplication **// TODO This block of code is reused elsewhere in the class, it should be abstracted
            if (!empty($params)) {
                $types = '';
                foreach ($params as $param) {
                    if (is_string($param)) {
                        $types .= 's';  // Strings
                    } else if (is_int($param)) {
                        $types .= 'i';  // Integers
                    } else if (is_float($param)) {
                        $types .= 'd';  // Doubles
                    } else {
                        $types .= 'b';  // Default for blobs and unknown types
                    }
                }

                $bind_names[] = $types;
                for ($i = 0; $i < count($params); $i++) {
                    $bind_name = 'bind' . $i;
                    $$bind_name = $params[$i];
                    $bind_names[] = &$$bind_name;
                }

                call_user_func_array(array($stmt, 'bind_param'), $bind_names);
            }
            //** END Code Duplication **//

            // Execute query
            $stmt->execute();

            return true;
        }

        return false;
    }

    /**
     * Before class is destroyed, close the connection to the database
     */
    public function __destruct() {
        mysqli_close($this->db);
    }
}