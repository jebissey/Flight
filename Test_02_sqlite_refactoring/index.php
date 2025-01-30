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
        'app\utils\CheckUser' => function (Container $container) {
            return new \app\utils\CheckUser(
                $container->get(Engine::class)
            );
        }
    ]);
    $container = $containerBuilder->build();
    $flight = $container->get(Engine::class);

    

// Error handling
Flight::map('error', function (Throwable $error) {
    echo $error->getTraceAsString();
  });
Flight::set('flight.log_errors', true);





    // Define routes
    $flight->route('GET /', function()  { include __DIR__.'/app/views/layout.php'; });

    $userController = $container->get('app\controllers\UserController');
    $flight->route('GET /users',             function()    use ($userController) { $userController->index(); });
    $flight->route('GET /users/edit/@id',    function($id) use ($userController) { $userController->editForm($id); });
    $flight->route('GET /users/add',         function()    use ($userController) { $userController->addForm(); });
    $flight->route('POST /users/add',        function()    use ($userController) { $userController->add(); });
    $flight->route('POST /users/update/@id', function($id) use ($userController) { $userController->update($id); });
    $flight->route('POST /users/delete/@id', function($id) use ($userController) { $userController->destroy($id); });

    
    $groupController = $container->get('app\controllers\GroupController');
    $flight->route('GET /groups',             function()    use ($groupController) { $groupController->index(); });
    $flight->route('GET /groups/edit/@id',    function($id) use ($groupController) { $groupController->editForm($id); });
    $flight->route('GET /groups/add',         function()    use ($groupController) { $groupController->addForm(); });
    $flight->route('POST /groups/add',        function()    use ($groupController) { $groupController->add(); });
    $flight->route('POST /groups/update/@id', function($id) use ($groupController) { $groupController->update($id); });
    $flight->route('POST /groups/delete/@id', function($id) use ($groupController) { $groupController->destroy($id); });


    $checkUser = $container->get('app\utils\CheckUser');
    $flight->route('/error403', function() use ($checkUser) { $checkUser->error403(); });
    $flight->route('/error499/@table/@id', function($table, $id) use ($checkUser) { $checkUser->error499($table, $id); });

    $flight->route('/*',        function() use ($checkUser) { $checkUser->error404(); });
    $flight->start();

} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}