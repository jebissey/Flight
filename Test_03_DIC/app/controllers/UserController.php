<?php

namespace app\controllers;


class UserController {

    public function add($name, $email) {
        try {
            if (empty($name) || empty($email)) {
                throw new \Exception("Name and email cannot be empty");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // If email is invalid, redirect back to edit with error and original data
                $flight->redirect('/edit/' . $id . '?error=Invalid email format&name=' . urlencode($name) . '&email=' . urlencode($email));
                return;
            }

            $stmt = $pdo->prepare('UPDATE users SET name = :name, email = :email WHERE id = :id');
            $stmt->execute(['name' => $name, 'email' => $email, 'id' => $id]);
            $flight->redirect('/');
        } catch (Exception $e) {
            $flight->redirect('/?error=' . urlencode($e->getMessage()));
        }
    }

    public function edit($id) {
    }   

    public function delete($id) {
    }
}