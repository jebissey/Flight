<?php

namespace app\controllers;

use PDO;
use flight\Engine;
use Exception;


class UserController {
    private PDO $pdo;
    private Engine $flight;

    public function __construct(PDO $pdo, Engine $flight) {
        $this->pdo = $pdo;
        $this->flight = $flight;
    }

    // Routes { -----------------------------------------------------------
    public function index() {
        $stmt = $this->pdo->query('SELECT * FROM users');
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $this->renderIndexView($users);
    }

    public function add() {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        
        try {
            $this->validateUserInput($name, $email);
            $this->insertUser($name, $email);
            $this->flight->redirect('/');
        } catch (Exception $e) {
            $this->flight->redirect('/?error=' . urlencode($e->getMessage()));
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = :id');
            $stmt->execute(['id' => $id]);
            $this->flight->redirect('/');
        } catch (Exception $e) {
            $this->flight->redirect('/?error=' . urlencode($e->getMessage()));
        }
    }

    public function edit($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $this->flight->redirect('/?error=User not found');
            return;
        }

        // Use GET parameters if present (for error scenario)
        $name = isset($_GET['name']) ? $_GET['name'] : $user['name'];
        $email = isset($_GET['email']) ? $_GET['email'] : $user['email'];

        $this->renderEditView($id, $name, $email);
    }

    public function update($id) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        
        try {
            $this->validateUserInput($name, $email);
            $this->updateUser($id, $name, $email);
            $this->flight->redirect('/');
        } catch (Exception $e) {
            $this->flight->redirect('/edit/' . $id . '?error=' . urlencode($e->getMessage()) . '&name=' . urlencode($name) . '&email=' . urlencode($email));
        }
    }
    // Routes } -----------------------------------------------------------


    // Views { -----------------------------------------------------------
    private function renderIndexView($users) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>User Management</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
        </head>
        <body>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6">
                        <h2>Add User</h2>
                        <?php if(isset($_GET['error'])): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
                        <?php endif; ?>
                        <form method="post" action="/add">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="name" placeholder="Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add User</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h2>Users List</h2>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['name']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td>
                                            <a href="/edit/<?= $user['id'] ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="post" action="/delete/<?= $user['id'] ?>" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    }

    private function renderEditView($id, $name, $email) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit User</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container mt-5">
                <h2>Edit User</h2>
                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
                <?php endif; ?>
                <form method="post" action="/update/<?= $id ?>">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($name) ?>" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($email) ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update User</button>
                    <a href="/" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </body>
        </html>
        <?php
    }
    // Views } -----------------------------------------------------------

    // Helpers { -----------------------------------------------------------
    private function validateUserInput($name, $email) {
        if (empty($name) || empty($email)) {
            throw new Exception("Name and email cannot be empty");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }
    }

    private function insertUser($name, $email) {
        $stmt = $this->pdo->prepare('INSERT INTO users (name, email) VALUES (:name, :email)');
        $stmt->execute(['name' => $name, 'email' => $email]);
    }

    private function updateUser($id, $name, $email) {
        $stmt = $this->pdo->prepare('UPDATE users SET name = :name, email = :email WHERE id = :id');
        $stmt->execute(['name' => $name, 'email' => $email, 'id' => $id]);
    }
    // Helpers } -----------------------------------------------------------
}

