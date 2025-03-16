<?php
require_once("common.php");

$targetFolderPath = APP_FOLDER_PATH . DIRECTORY_SEPARATOR . APP_UPLOAD_FOLDER;
$directory = opendir($targetFolderPath);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>List of files in "<?= APP_UPLOAD_FOLDER ?>"</title>
</head>
<body>
<p><a href="index.html">Back to Homepage</a></p>
<h2>List of files in "<?= APP_UPLOAD_FOLDER ?>"</h2>

<ul>
    <?php while ($file = readdir($directory)):
        // We don't want to list "current directory" and "parent directory" pseudo-files, which are represented as . and ..
        if ($file == "." || $file == "..") continue;

        if (!is_dir($file)): ?>
            <li><a href="<?= APP_URL_PATH . "/" . APP_UPLOAD_FOLDER . "/" . rawurlencode($file) ?>"><?= $file ?></a></li>
        <?php endif;
    endwhile;
    closedir($directory); ?>
</ul>

</body>
</html>
