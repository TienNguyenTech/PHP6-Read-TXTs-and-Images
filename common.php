<?php
$db_hostname = "localhost";
$db_username = "fit2104";
$db_password = "fit2104";
$db_name = "fit2104_23s2_lab08";

$dsn = "mysql:host=$db_hostname;dbname=$db_name";
$dbh = new PDO($dsn, "$db_username", "$db_password");

function displayPDOError(PDOException $exception): void {
    // Set appropriate headers and HTTP response to display error message
    header('HTTP/1.1 400 Bad Request');
    header('Content-Type:text/plain');

    // Show error messages of the exception when execution is failed
    echo $exception->getMessage();
}

// set the folder to accept file uploads
define("APP_UPLOAD_FOLDER", "files");
// the absolute path to the root of project folder
define("APP_FOLDER_PATH", __DIR__);
// and the URL full path to the root of the project
define("APP_URL_PATH", substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT'])));
