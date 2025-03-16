<?php
global $dbh;
require_once("../common.php");

// Allowed file types
$allowed_types = [
    'text/plain',
    'image/jpeg',
    'image/png'
];

// If the user has completed the form:
if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    try {
        // Process the file upload first
        if (isset($_FILES['path']) && $_FILES['path']['error'] == 0) {
            if (in_array($_FILES['path']['type'], $allowed_types)) {
                // Set the file destination and move it from its temporary location
                $destination = APP_FOLDER_PATH . DIRECTORY_SEPARATOR . APP_UPLOAD_FOLDER . DIRECTORY_SEPARATOR . $_FILES['path']['name'];
                if (move_uploaded_file($_FILES['path']['tmp_name'], $destination)) {

                    // Add new student based on the form received
                    $query = "INSERT INTO `exhibits`
                        (`title`, `source_url`, `path`) VALUES 
                        (:title,  :source_url,  :path)";
                    $stmt = $dbh->prepare($query);

                    // Execute the query
                    $stmt->execute([
                        'title' => $_POST['title'],
                        'source_url' => $_POST['source_url'],
                        'path' => $_FILES['path']['name']
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
    }
else: ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Add Exhibit</title>
    </head>
    <body>
    <h1>Add new exhibit</h1>

    <form method="post" enctype="multipart/form-data">
        <label for="exhibit-title">Title:</label><br>
        <input type="text" maxlength="255" id="exhibit-title" name="title" size="40" required><br>

        <label for="exhibit-source-url">Source URL:</label><br>
        <textarea id="exhibit-source-url" name="source_url" cols="40" rows="5" required></textarea><br>

        <label for="exhibit-file">File:</label><br>
        <input type="file" id="exhibit-file" name="path" required><br>

        <br>

        <input type="submit" value="Add">
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
                // Check if a file has been selected
                if (event.target.files.length === 1) {
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
                } else {
                    event.target.setCustomValidity("A file must be provided");
                }
            }
        }
    </script>
    </body>
    </html>
<?php endif; ?>