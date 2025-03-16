<?php
global $dbh;
require_once("../common.php");

// Allowed file types
$allowed_types = [
    'text/plain',
    'image/jpeg',
    'image/png'
];

// Test if exhibit id has been provided. If not, take user back to the listing page
if (empty($_GET['id'])) {
    header('Location: index.php');
}

// Read the record from database with ID
$stmt = $dbh->prepare("SELECT * FROM `exhibits` WHERE `id` = :id");
$stmt->execute(['id' => $_GET['id']]);
if ($stmt->rowCount() == 1) {
    $exhibitData = $stmt->fetchObject();
} else {
    // If the record is not found (rowcount is not 1), send user back to listing page (invalid ID)
    header('Location: index.php');
}

// If the user has completed the form:
if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    try {
        // Process the file upload first
        if (!isset($_FILES['path']) || $_FILES['path']['error'] == 4) {
            // No file is uploaded, only update other fields in the database
            $query = "UPDATE `exhibits` SET 
                  `title`      = :title, 
                  `source_url` = :source_url
            WHERE `id`         = :id";
            $stmt = $dbh->prepare($query);

            // Execute the query
            $stmt->execute([
                'title' => $_POST['title'],
                'source_url' => $_POST['source_url'],
                'id' => $_GET['id']
            ]);

            // And send the user back to where we were
            header('Location: index.php');
        }
        if (isset($_FILES['path']) && $_FILES['path']['error'] == 0) {
            if (in_array($_FILES['path']['type'], $allowed_types)) {
                // Delete old file first
                $filePath = APP_FOLDER_PATH . DIRECTORY_SEPARATOR . APP_UPLOAD_FOLDER . DIRECTORY_SEPARATOR . $exhibitData->path;
                if (unlink($filePath) === false)
                    // Just in case the file cannot be deleted
                    throw new Exception("Failed to delete file from filesystem: " . $filePath);

                // Set the file destination and move it from its temporary location
                $destination = APP_FOLDER_PATH . DIRECTORY_SEPARATOR . APP_UPLOAD_FOLDER . DIRECTORY_SEPARATOR . $_FILES['path']['name'];
                if (move_uploaded_file($_FILES['path']['tmp_name'], $destination)) {
                    // Update the record based on the form received
                    $query = "UPDATE `exhibits` SET 
                          `title`      = :title, 
                          `source_url` = :source_url,
                          `path`       = :path
                    WHERE `id`         = :id";
                    $stmt = $dbh->prepare($query);

                    // Execute the query
                    $stmt->execute([
                        'title' => $_POST['title'],
                        'source_url' => $_POST['source_url'],
                        'path' => $_FILES['path']['name'],
                        'id' => $_GET['id']
                    ]);

                    // And send the user back to where we were
                    header('Location: index.php');
                } else {
                    throw new Exception("Cannot store file. See warning for more information. ");
                }
            } else {
                throw new Exception("Type of the uploaded file is not allowed: " . $_FILES['path']['type']);
            }
        } else {
            throw new Exception("Uploaded file cannot be processed. Error code: " . $_FILES['path']['error']);
        }
    } catch (PDOException $e) {
        displayPDOError($e);
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
else: ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Update exhibit #<?= $exhibitData->id ?></title>
    </head>
    <body>
    <h1>Update exhibit #<?= $exhibitData->id ?></h1>

    <form method="post" enctype="multipart/form-data">
        <label for="exhibit-title">Title:</label><br>
        <input type="text" maxlength="255" id="exhibit-title" name="title" size="40" value="<?= $exhibitData->title ?>" required><br>

        <label for="exhibit-source-url">Source URL:</label><br>
        <textarea id="exhibit-source-url" name="source_url" cols="40" rows="5" required><?= $exhibitData->source_url ?></textarea><br>

        <label for="exhibit-file">File:</label><br>
        <input type="file" id="exhibit-file" name="path"><br>

        <br>

        <input type="submit" value="Update">
    </form>

    <script>
        // Allowed file types
        const allowedFiletypes = [
            'text/plain',
            'image/jpeg',
            'image/png'
        ];
        document.getElementById('exhibit-file').onchange = (event) => {
            // Check if JS is allowed to do file manipulation
            if (typeof FileReader !== "undefined") {
                // Get file type and size
                let fileType = event.target.files[0].type;
                let fileSize = event.target.files[0].size;

                if (allowedFiletypes.indexOf(fileType) === -1)
                    // Check if the file is the correct type
                    event.target.setCustomValidity("File must be either a plaintext file, or JPEG or PNG image file");
                else if (fileSize > 2000000)
                    // Check if the file ls bigger than 2MB
                    event.target.setCustomValidity("File size must not exceed 2MB");
                else
                    // Otherwise clear the invalid message from the form control
                    event.target.setCustomValidity("");
            }
        }
    </script>
    </body>
    </html>
<?php endif; ?>