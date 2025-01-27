<h1>Add Group</h1>
<form action="/groups/add" method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" id="inactivated" name="inactivated" class="form-check-input">
        <label for="inactivated" class="form-check-label">Inactivated</label>
    </div>
    <button type="submit" class="btn btn-primary">Add</button>
</form>