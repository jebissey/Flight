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

    $flight = $container->get(Engine::class);

    // Get controller instances
    $userController = $container->get('app\controllers\UserController');

    // Define routes
    $flight->route('GET /',             function()    use ($userController) { $userController->index(); });
    $flight->route('POST /add',         function()    use ($userController) { $userController->add(); });
    $flight->route('POST /delete/@id',  function($id) use ($userController) { $userController->delete($id); });
    $flight->route('GET /edit/@id',     function($id) use ($userController) { $userController->edit($id); });
    $flight->route('POST /update/@id',  function($id) use ($userController) { $userController->update($id); });

    $flight->start();

} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}