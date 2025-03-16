<?php
global $dbh;
require_once("../common.php");


if (!empty($_GET["id"])) {
    try {
        // Get file path from database first
        $query = "SELECT * FROM `exhibits` WHERE `id` = :id";
        $stmt = $dbh->prepare($query);
        $stmt->execute([
            'id' => $_GET["id"]
        ]);
        if ($stmt->rowCount() == 1 && $row = $stmt->fetchObject()) {
            // Delete the file
            $filePath = APP_FOLDER_PATH . DIRECTORY_SEPARATOR . APP_UPLOAD_FOLDER . DIRECTORY_SEPARATOR . $row->path;
            if (unlink($filePath) === false)
                // Just in case the file cannot be deleted
                throw new Exception("Failed to delete file from filesystem: " . $filePath);

            // Delete the record with the given record ID
            $query = "DELETE FROM `exhibits` WHERE `id` = :id";
            $stmt = $dbh->prepare($query);

            // Execute the query
            $stmt->execute([
                'id' => $_GET["id"]
            ]);

            // And send the user back to where we were
            header('Location: index.php');
        }
    } catch (PDOException $e) {
        displayPDOError($e);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}