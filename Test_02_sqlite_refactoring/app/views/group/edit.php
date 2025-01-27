<h1>Edit Group</h1>
<form action="/groups/update/<?= $group['Id'] ?>" method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($group['Name']) ?>" required>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" id="inactivated" name="inactivated" class="form-check-input" <?= $group['Inactivated'] ? 'checked' : '' ?>>
        <label for="inactivated" class="form-check-label">Inactivated</label>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>