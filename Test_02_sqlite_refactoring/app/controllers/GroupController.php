<?php
namespace app\controllers;

class GroupController extends BaseController {
    public function index(): void {
        $groups = $this->fetchAll('Group');
        $this->renderView('group/index', ['groups' => $groups]);
    }

    public function addForm(): void {
        $this->renderView('group/add');
    }

    public function add(): void {
        $name = $_POST['name'] ?? '';
        $inactivated = isset($_POST['inactivated']) ? 1 : 0;

        $stmt = $this->pdo->prepare('INSERT INTO "Group" (Name, Inactivated) VALUES (:name, :inactivated)');
        $stmt->execute(['name' => $name, 'inactivated' => $inactivated]);

        $this->flight->redirect('/groups');
    }

    public function editForm(int $id): void {
        $group = $this->fetchById('Group', $id);
        if (!$group) {
            $this->flight->redirect('/groups?error=Group not found');
            return;
        }

        $this->renderView('group/edit', ['group' => $group]);
    }

    public function update(int $id): void {
        $name = $_POST['name'] ?? '';
        $inactivated = isset($_POST['inactivated']) ? 1 : 0;

        $stmt = $this->pdo->prepare('UPDATE "Group" SET Name = :name, Inactivated = :inactivated WHERE Id = :id');
        $stmt->execute(['name' => $name, 'inactivated' => $inactivated, 'id' => $id]);

        $this->flight->redirect('/groups');
    }

    public function destroy(int $id): void {
        $this->delete('Group', $id);
        $this->flight->redirect('/groups');
    }
}