<?php
require_once '../../vendor/autoload.php';

use Dice\Dice;

$dice = new Dice();

$dbPath = __DIR__ . '/../../users.sqlite';

// Créer la base si elle n'existe pas
if (!file_exists($dbPath)) {
    $handle = fopen($dbPath, 'w');
    fclose($handle);
    chmod($dbPath, 0666);
}

$dsn = 'sqlite:' . $dbPath;

try {
    $pdo = new PDO($dsn, null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Créer la table si elle n'existe pas
    $pdo->exec('CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        email TEXT UNIQUE
    )');

} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}

$dice->addRule(PDO::class, [
    'shared' => true,
    'constructParams' => [$dsn]
]);

return $dice;