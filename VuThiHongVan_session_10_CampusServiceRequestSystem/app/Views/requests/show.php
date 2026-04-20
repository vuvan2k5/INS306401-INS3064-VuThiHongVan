<h1>Request Detail</h1>

<p>Title: <?= $request['title'] ?></p>
<p>Description: <?= $request['description'] ?></p>
<p>Status: <?= $request['status'] ?></p>

<form method="POST" action="?action=updateStatus">
    <input type="hidden" name="id" value="<?= $request['id'] ?>">

    <select name="status">
        <option>Pending</option>
        <option>In Progress</option>
        <option>Done</option>
    </select>

    <button type="submit">Update</button>
</form>