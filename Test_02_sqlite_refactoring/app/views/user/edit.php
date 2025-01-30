<h1>Edit User</h1>
<form action="/users/update/<?= $user['id'] ?>" method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="text" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="/" class="btn btn-secondary">Cancel</a>
</form>
