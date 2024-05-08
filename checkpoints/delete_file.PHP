<?php
// Get file path from POST request
$filePath = $_POST["filePath"];

// Check if file exists and delete it
if (file_exists($filePath)) {
    if (unlink($filePath)) {
        echo "File deleted successfully";
    } else {
        http_response_code(500);
        echo "Error deleting file";
    }
} else {
    echo "File does not exist";
}
?>
