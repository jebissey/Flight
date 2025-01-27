<h1>Add User</h1>
<form action="/users/add" method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="text" id="email" name="email" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Add</button>
    <a href="/" class="btn btn-secondary">Cancel</a>
</form>