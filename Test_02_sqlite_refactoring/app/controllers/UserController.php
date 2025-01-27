<?php

namespace app\controllers;

use Exception;

class UserController extends BaseController {
    public function index(): void {
        $users = $this->fetchAll('users');
        $this->renderView('user/index', ['users' => $users]);
    }

    public function addForm(): void {
        $this->renderView('user/add');
    }

    public function add(): void {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);

        try {
            $this->validateUserInput($name, $email);

            $stmt = $this->pdo->prepare('INSERT INTO "users" (name, email) VALUES (:name, :email)');
            $stmt->execute(['name' => $name, 'email' => $email]);

            $this->flight->redirect('/users');
        } catch (Exception $e) {
            $this->flight->redirect('/users/?error=' . urlencode($e->getMessage()));
        }
    }

    public function editForm(int $id): void {
        $user = $this->fetchById('users', $id);
        if (!$user) {
            $this->flight->redirect('/users?error=User not found');
            return;
        }

        $this->renderView('user/edit', ['user' => $user]);
    }

    public function update(int $id): void {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);

        $stmt = $this->pdo->prepare('UPDATE "users" SET Name = :name, email = :email WHERE Id = :id');
        $stmt->execute(['name' => $name, 'email' => $email, 'id' => $id]);

        $this->flight->redirect('/users');
    }

    public function destroy(int $id): void {
        $this->delete('users', $id);
        $this->flight->redirect('/users');
    }


    private function validateUserInput($name, $email) {
        if (empty($name) || empty($email)) {
            throw new Exception("Name and email cannot be empty");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }
    }
}


