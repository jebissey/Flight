<?php

namespace app\controllers;

use PDO;
use flight\Engine;
use Exception;


class AccessAttemptsController {
    private PDO $pdo;
    private Engine $flight;

    public function __construct(PDO $pdo, Engine $flight) {
        $this->pdo = $pdo;
        $this->flight = $flight;
    }

    // Routes { -----------------------------------------------------------
    public function error403() {
        echo '<h1>' . $_SERVER['REQUEST_URI'] . '</h1>';
        echo '<h2>403</h2> not allowed';
?>
<script>
    setTimeout(function() {
        window.location.href = '/';
    }, 1000);
</script>
<?php
    }

    public function error404() {
        echo '<h1>' . $_SERVER['REQUEST_URI'] . '</h1>' . ' not found';
?>
<script>
    setTimeout(function() {
        window.location.href = '/';
    }, 1000);
</script>
<?php
    }
}