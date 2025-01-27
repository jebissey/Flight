<?php
namespace app\controllers;

use PDO;
use flight\Engine;

abstract class BaseController {
    protected PDO $pdo;
    protected Engine $flight;

    public function __construct(PDO $pdo, Engine $flight) {
        $this->pdo = $pdo;
        $this->flight = $flight;
    }

    protected function fetchAll(string $table): array {
        $stmt = $this->pdo->query('SELECT * FROM "'.$table.'"');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function fetchById(string $table, int $id): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM "'.$table.'" WHERE Id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    protected function delete(string $table, int $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM "'.$table.'" WHERE Id = :id');
        return $stmt->execute(['id' => $id]);
    }

    protected function renderView(string $view, array $data = []): void {
        extract($data);
        ob_start();
        include __DIR__ . "/../views/$view.php";
        $content = ob_get_clean();
        include __DIR__ . "/../views/layout.php";
    }
}