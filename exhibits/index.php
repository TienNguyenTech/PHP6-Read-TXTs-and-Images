<?php
global $dbh;
require_once("../common.php");

$queryStudents = "SELECT * FROM `exhibits`";

$stmt = $dbh->prepare($queryStudents);
$stmt->execute();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>List of exhibits</title>

    <style>
        table, tr, th, td {
            border: 1px black solid;
        }
    </style>
</head>
<body>
<p><a href="../index.html">Back to Homepage</a> <a href="add.php">Add new exhibit</a></p>
<table class="table">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Title</th>
        <th scope="col">Source</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($row = $stmt->fetchObject()): ?>
        <tr>
            <th scope="row"><?= $row->id ?></th>
            <td class="title"><?= $row->title ?></td>
            <td><a href="<?= $row->source_url ?>"><?= $row->source_url ?></a></td>
            <td>
                <a href="<?= APP_URL_PATH . "/" . APP_UPLOAD_FOLDER . "/" . rawurlencode($row->path) ?>">View</a>
                <a href="update.php?id=<?= $row->id ?>">Update</a>
                <a href="delete.php?id=<?= $row->id ?>" class="delete-exhibit">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<script>
    // Add a confirmation box to all delete buttons
    Array.from(document.getElementsByClassName('delete-exhibit')).forEach((element) => {
        element.addEventListener('click', (event) => {
            // Get exhibits from the table row
            let buttonParent = event.target.parentNode.parentNode;
            // Render the dialog box
            if (!confirm('Are you sure to delete the exhibit named "' + buttonParent.querySelector('.title').textContent + '"?'))
                event.preventDefault();  // If the user cancel the dialog box, do nothing
        })
    });
</script>
</body>
</html>
