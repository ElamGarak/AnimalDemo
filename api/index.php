<?php
/**
 * Created using PhpStorm.
 * Author: Josh Pacheco <joshua.pacheco@gmail.com>
 * Project: AnimalDemo
 * Date: 3/26/2016
 */

namespace api;

require('Config.php'); // Require config here

use api\Enums\EndPoints;
use api\libraries\Request;
use Exception;

/**
 * This is the core api controller.  Here all incoming request are routed to the proper endpoint.  Class instantiaton
 * should only occur here and no where else in the api with the exception of lazy getters (discouraged).  Instantiated
 * Classes should make use of dependency injection.
 *
 * TODO This is the only procedural part of the api, it can probably be made into its own class at a later date
 */

$config = Config::get(); // Get config data
$request= new Request(); // Instantiate class for request access operations
$params = $request->fetch(); // Pull all incoming Restful data

try {
    // TODO Route is a required param key and should be validated prior
    switch ($params['route']) {
        case EndPoints::LISTS: // Drop list endpoint
            $animalDetailDao = new AnimalDetailsDao($config);
            $animalDetailsService= new AnimalDetailsService($animalDetailDao);
            // These are no longer needed, remove so they do not interfere with dynamic operations in the service or dao
            // TODO this is repeated and can be abstracted out
            unset($params['route']);
            unset($params['timezone']);
            $output = $animalDetailsService->getLists();
            break;
        case EndPoints::ANIMAL_LIST: // Animal list endpoint
            $animalListDao = new AnimalListDao($config);
            $animalListService= new AnimalListService($animalListDao);
            // This is longer needed, remove so it does not interfere with dynamic operations in the service or dao
            // TODO this is repeated and can be abstracted out
            unset($params['route']);
            $output = $animalListService->get($params);
            break;
        case EndPoints::ANIMAL_LIST_COUNT: // Record count endpoint
            $animalListDao = new AnimalListDao($config);
            $animalListService= new AnimalListService($animalListDao);
            $output = $animalListService->getCount();
            break;
        case EndPoints::ANIMAL_DETAILS: // Animal details endpoint
            // TODO These instantiations are repeated several times in this controle, they should be placed in their own method
            $animalDetailDao = new AnimalDetailsDao($config);
            $animalDetailsService= new AnimalDetailsService($animalDetailDao);
            $output = $animalDetailsService->get($params);
            break;
        case EndPoints::UPDATE: // Animal detail update
            // TODO These instantiations are repeated several times in this controle, they should be placed in their own method
            $animalDetailDao = new AnimalDetailsDao($config);
            $animalDetailsService= new AnimalDetailsService($animalDetailDao);
            unset($params['route']);
            unset($params['timezone']);
            $output = $animalDetailsService->put($params);
            break;
        case EndPoints::ADD: // Animal detail adding
            // TODO These instantiations are repeated several times in this controle, they should be placed in their own method
            $animalDetailDao = new AnimalDetailsDao($config);
            $animalDetailsService= new AnimalDetailsService($animalDetailDao);
            // These are no longer needed, remove so they do not interfere with dynamic operations in the service or dao
            // TODO this is repeated and can be abstracted out
            unset($params['route']);
            unset($params['timezone']);
            $output = $animalDetailsService->post($params);
            break;
        case EndPoints::DELETE: // Animal detail removal
            $animalDetailDao = new AnimalDetailsDao($config);
            $animalDetailsService= new AnimalDetailsService($animalDetailDao);
            // These are no longer needed, remove so they do not interfere with dynamic operations in the service or dao
            // TODO this is repeated and can be abstracted out
            unset($params['route']);
            unset($params['timezone']);
            $output = $animalDetailsService->delete($params);
            break;
        default:
            throw new Exception("No endpoint defined", 500);
    }
} catch (Exception $e) {
    die($e->getMessage());
}

// Output for 'display' results from called endpoint as JSON
echo json_encode($output);