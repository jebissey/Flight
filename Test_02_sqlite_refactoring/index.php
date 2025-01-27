<?php
require_once 'vendor/autoload.php';

use flight\Engine;
use DI\Container;
use DI\ContainerBuilder;


try {
    // Set up PHP-DI
    $containerBuilder = new ContainerBuilder();
    $containerBuilder->addDefinitions([
        PDO::class => function () {
            $pdo = new PDO('sqlite:users.sqlite');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        },
        Engine::class => function () {
            return new Engine();
        },
        'app\controllers\UserController' => function (Container $container) {
            return new \app\controllers\UserController(
                $container->get(PDO::class),
                $container->get(Engine::class)
            );
        },
        'app\controllers\AccessAttempsController' => function (Container $container) {
            return new \app\controllers\AccessAttemptsController(
                $container->get(PDO::class),
                $container->get(Engine::class)
            );
        }
    ]);
    $container = $containerBuilder->build();

    // Create the database table if it doesn't exist
    $pdo = $container->get(PDO::class);
    $pdo->exec('CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        email TEXT UNIQUE
    )');
    $pdo->exec('CREATE TABLE IF NOT EXISTS "Group" (
        "Id"	INTEGER,
        "Name"	TEXT NOT NULL,
        "Inactivated"	INTEGER NOT NULL DEFAULT 0,
        PRIMARY KEY("Id")
    )');

    $flight = $container->get(Engine::class);


    // Define routes
    $flight->route('GET /', function()  { include __DIR__.'/app/views/layout.php'; });

    $userController = $container->get('app\controllers\UserController');
    $flight->route('GET /users',             function()    use ($userController) { return $userController->index(); });
    $flight->route('GET /users/edit/@id',    function($id) use ($userController) { return $userController->edit($id); });
    $flight->route('GET /users/add',         function()    use ($userController) { return $userController->addForm(); });
    $flight->route('POST /users/add',        function()    use ($userController) { return $userController->add(); });
    $flight->route('POST /users/update/@id', function($id) use ($userController) { return $userController->update($id); });
    $flight->route('POST /users/delete/@id', function($id) use ($userController) { return $userController->destroy($id); });

    
    $groupController = $container->get('app\controllers\GroupController');
    $flight->route('GET /groups',             function()    use ($groupController) { return $groupController->index(); });
    $flight->route('GET /groups/edit/@id',    function($id) use ($groupController) { return $groupController->editForm($id); });
    $flight->route('GET /groups/add',         function()    use ($groupController) { return $groupController->addForm(); });
    $flight->route('POST /groups/add',        function()    use ($groupController) { return $groupController->add(); });
    $flight->route('POST /groups/update/@id', function($id) use ($groupController) { return $groupController->update($id); });
    $flight->route('POST /groups/delete/@id', function($id) use ($groupController) { return $groupController->destroy($id); });


    $accessAttemptsController = $container->get('app\controllers\AccessAttemptsController');
    $flight->route('*/add',      function() use ($accessAttemptsController) { $accessAttemptsController->error403(); });
    $flight->route('*/edit/*',   function() use ($accessAttemptsController) { $accessAttemptsController->error403(); });
    $flight->route('*/update/*', function() use ($accessAttemptsController) { $accessAttemptsController->error403(); });
    $flight->route('*/delete/*', function() use ($accessAttemptsController) { $accessAttemptsController->error403(); });

    $flight->route('/*',         function() use ($accessAttemptsController) { $accessAttemptsController->error404(); });

    $flight->start();

} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}