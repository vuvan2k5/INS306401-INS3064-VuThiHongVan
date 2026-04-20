<h1>Request List</h1>

<a href="create.html">Create Request</a>

<ul>
<?php foreach ($requests as $r): ?>
    <li>
        <a href="?action=show&id=<?= $r['id'] ?>">
            <?= $r['title'] ?> (<?= $r['status'] ?>)
        </a>
    </li>
<?php endforeach; ?>
</ul>