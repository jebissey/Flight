<?php
require_once 'vendor/autoload.php';

use flight\Engine;
use DI\Container;
use DI\ContainerBuilder;

use Tracy\Debugger;
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    Debugger::enable(Debugger::Development, __DIR__ . '/log');
} else {
    Debugger::enable(Debugger::Production);
}


$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    PDO::class => function () {
        $pdo = new PDO('sqlite:database.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    },
    Engine::class => function () {
        return new Engine();
    },
    'controllers\GroupController' => function (Container $container) {
        return new \controllers\GroupController(
            $container->get(PDO::class),
            $container->get(Engine::class)
        );
    },
]);
$container = $containerBuilder->build();
$flight = $container->get(Engine::class);


// Routes
$groupController = $container->get('controllers\GroupController');
$flight->route('GET  /groups',            function()    use ($groupController) { $groupController->index(); });
$flight->route('GET  /groups/create',     function()    use ($groupController) { $groupController->create(); });
$flight->route('POST /groups/create',     function()    use ($groupController) { $groupController->create(); });
$flight->route('GET  /groups/edit/@id',   function($id) use ($groupController) { $groupController->edit($id); });
$flight->route('POST /groups/edit/@id',   function($id) use ($groupController) { $groupController->edit($id); });
$flight->route('POST /groups/delete/@id', function($id) use ($groupController) { $groupController->delete($id); });

$flight->start();