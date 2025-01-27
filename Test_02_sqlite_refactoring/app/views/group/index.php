<h1>Groups</h1>
<a href="/groups/add" class="btn btn-primary mb-3">Add Group</a>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Inactivated</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($groups as $group): ?>
            <tr>
                <td><?= htmlspecialchars($group['Id']) ?></td>
                <td><?= htmlspecialchars($group['Name']) ?></td>
                <td><?= $group['Inactivated'] ? 'Yes' : 'No' ?></td>
                <td>
                    <a href="/groups/edit/<?= $group['Id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <form action="/groups/delete/<?= $group['Id'] ?>" method="POST" style="display:inline;">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>