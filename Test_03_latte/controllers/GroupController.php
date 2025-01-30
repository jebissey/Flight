<?php
namespace controllers;

use PDO;

class GroupController extends BaseController {

    public function index() {
        $stmt = $this->pdo->query('SELECT * FROM "Group" WHERE Inactivated = 0');
        $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo $this->latte->render('views/groups/index.latte', [
            'groups' => $groups
        ]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = isset($_POST['name']) ? $this->sanitizeInput($_POST['name']) : '';
            $selfRegistration = isset($_POST['selfRegistration']) ? 1 : 0;
            
            if (empty($name)) {
                // Gérer l'erreur si le nom est vide
                echo $this->latte->render('views/groups/create.latte', [
                    'error' => 'Le nom du groupe est requis'
                ]);
                return;
            }
            
            $stmt = $this->pdo->prepare('INSERT INTO "Group" (Name, SelfRegistration) VALUES (?, ?)');
            $stmt->execute([$name, $selfRegistration]);
            
            $this->flight->redirect('/groups');
            return;
        }
        
        echo $this->latte->render('views/groups/create.latte');
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = isset($_POST['name']) ? $this->sanitizeInput($_POST['name']) : '';
            $selfRegistration = isset($_POST['selfRegistration']) ? 1 : 0;
            
            if (empty($name)) {
                $stmt = $this->pdo->prepare('SELECT * FROM "Group" WHERE Id = ?');
                $stmt->execute([$id]);
                $group = $stmt->fetch(PDO::FETCH_ASSOC);
                
                echo $this->latte->render('views/groups/edit.latte', [
                    'group' => $group,
                    'error' => 'Le nom du groupe est requis'
                ]);
                return;
            }
            
            $stmt = $this->pdo->prepare('UPDATE "Group" SET Name = ?, SelfRegistration = ? WHERE Id = ?');
            $stmt->execute([$name, $selfRegistration, $id]);
            
            $this->flight->redirect('/groups');
            return;
        }
        
        $stmt = $this->pdo->prepare('SELECT * FROM "Group" WHERE Id = ?');
        $stmt->execute([$id]);
        $group = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$group) {
            $this->flight->redirect('/groups');
            return;
        }
        
        echo $this->latte->render('views/groups/edit.latte', [
            'group' => $group
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare('UPDATE "Group" SET Inactivated = 1 WHERE Id = ?');
        $stmt->execute([$id]);
        
        $this->flight->redirect('/groups');
    }
}